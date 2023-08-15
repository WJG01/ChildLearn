<?php
include("config.php");
require 'vendor/autoload.php';

use Pkerrigan\Xray\Trace;
use Pkerrigan\Xray\SqlSegment;
use Pkerrigan\Xray\Segment;
use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;
use Pkerrigan\Xray\RemoteSegment;

if (!isset($_SESSION)) {
    session_start();
}

// class XRayControllerClass() {}

function createNewXrayTracing()
{
    if (!isset($_SESSION['trace_id']) && !isset($_SESSION['parent_id'])) {
        Trace::getInstance()
            ->setTraceHeader($_SERVER['HTTP_X_AMZN_TRACE_ID'] ?? null)
            ->setName('ElasticBeanStalk Service')
            //switch back to this when we deploy
            // ->setUrl('http://childlearn-env-1.eba-49nd49e2.us-east-1.elasticbeanstalk.com')
            ->setUrl('childlearn.us-east-1.elasticbeanstalk.com')
            ->setMethod($_SERVER['REQUEST_METHOD'])
            ->begin(100);
    } else {
        createFromExistingXrayTracing('childlearn.us-east-1.elasticbeanstalk.com');
    }

    if (!isset($_SESSION['trace_id'])) {
        setTrace_ParendID();
    }
}

function createFromExistingXrayTracing($name)
{
    Trace::getInstance()
        ->setTraceHeader($_SERVER['HTTP_X_AMZN_TRACE_ID'] ?? null)
        ->setParentId($_SESSION['parent_id'])
        ->setTraceId($_SESSION['trace_id'])
        ->setIndependent(true)
        ->setName($name)
        ->setUrl($_SERVER['REQUEST_URI'])
        ->setMethod($_SERVER['REQUEST_METHOD'])
        ->begin(100);
}

function createNewRemoteSegment($name)
{
    Trace::getInstance()
        ->getCurrentSegment()
        ->addSubsegment(
            (new RemoteSegment())
                ->setName($name)
                ->begin()
        );
}

function createNewSQLSegment($name)
{
    Trace::getInstance()
        ->getCurrentSegment()
        ->addSubsegment(
            (new SqlSegment())
                ->setName($name)
                ->setUrl('awseb-e-ecfp7dp5pn-stack-awsebrdsdatabase-3kt0ellbqgdt.c1cevqakx6ry.us-east-1.rds.amazonaws.com')
                ->setDatabaseType('MySQL Community')
                // ->setQuery($query)
                ->begin()
        );
}

function end_Segment()
{
    Trace::getInstance()
        ->getCurrentSegment()
        ->end();
}

function set_SQLSegmentQuery($query)
{
    Trace::getInstance()
        ->getCurrentSegment()
        ->setQuery($query)
        ->end();
}

// function createNewSQLSegment($name)
// {
//     global $sqlSegment;

//     if (!$sqlSegment) {
//         $sqlSegment = new SqlSegment();
//         $sqlSegment
//             ->setName($name)
//             ->setUrl('awseb-e-ecfp7dp5pn-stack-awsebrdsdatabase-3kt0ellbqgdt.c1cevqakx6ry.us-east-1.rds.amazonaws.com')
//             ->setDatabaseType('MySQL Community')
//             ->begin(100);
//     }

//     return $sqlSegment;
// }



// function set_SQLSegmentQuery($name, $query)
// {
//     $sqlSegment = createNewSQLSegment($name);
//     $sqlSegment->setQuery($query);
//     $sqlSegment->end();
// }


function setTrace_ParendID()
{
    if (!isset($_SESSION['trace_id']) && !isset($_SESSION['parent_id'])) {
       // echo "new trace session SET !";
        $_SESSION['trace_id'] = Trace::getInstance()->getTraceId();
        $_SESSION['parent_id'] = Trace::getInstance()->getId();
    }
}

function submitXrayTracing()
{
    Trace::getInstance()
        ->end()
        ->setResponseCode(http_response_code())
        ->submit(new DaemonSegmentSubmitter());
    //Print the Trace ID
   // print_r(Trace::getInstance());
}
