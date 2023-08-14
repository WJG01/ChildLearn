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

if (!function_exists('createNewXrayTracing')) {
    function createNewXrayTracing()
    {
        if (!isset($_SESSION['trace_id']) && !isset($_SESSION['parent_id'])) {
            Trace::getInstance()
                ->setTraceHeader($_SERVER['HTTP_X_AMZN_TRACE_ID'] ?? null)
                ->setName('childlearn.us-east-1.elasticbeanstalk.com')
                //switch back to this when we deploy
                // ->setUrl('http://childlearn-env-1.eba-49nd49e2.us-east-1.elasticbeanstalk.com')
                ->setUrl('childlearn.us-east-1.elasticbeanstalk.com')
                ->setMethod($_SERVER['REQUEST_METHOD'])
                ->begin(100);

            setTrace_ParendID();
        }
    }
}

if (!function_exists('createFromExistingXrayTracing')) {
    function createFromExistingXrayTracing()
    {
        Trace::getInstance()
            ->setTraceHeader($_SERVER['HTTP_X_AMZN_TRACE_ID'] ?? null)
            ->setParentId($_SESSION['parent_id'])
            ->setTraceId($_SESSION['trace_id'])
            ->setIndependent(true)
            ->setName('childlearn.us-east-1.elasticbeanstalk.com')
            ->setUrl($_SERVER['REQUEST_URI'])
            ->setMethod($_SERVER['REQUEST_METHOD'])
            ->begin(100);
    }
}

if (!function_exists('createNewRemoteSegment')) {
    function createNewRemoteSegment($name)
    {
        Trace::getInstance()
            ->getCurrentSegment()
            ->addSubsegment(
                (new RemoteSegment())
                    ->setName($name)
                    ->setUrl($name)
                    ->begin()
            );

    }
}

if (!function_exists('createNewS3RemoteSegment')) {
    function createNewS3RemoteSegment()
    {
        Trace::getInstance()
            ->getCurrentSegment()
            ->addSubsegment(
                (new RemoteSegment())
                    ->setName('childlearn-bucket.s3.amazonaws.com')
                    // ->setUrl('childlearn-bucket.s3.amazonaws.com')
                    ->begin()
            );
    }
}

if (!function_exists('createNewSNSRemoteSegment')) {
    function createNewSNSRemoteSegment()
    {
        Trace::getInstance()
            ->getCurrentSegment()
            ->addSubsegment(
                (new RemoteSegment())
                    ->setName('aws:sns:us-east-1:941317794938:ChildLearnEmailTopic')
                    // ->setUrl('aws:sns:us-east-1:941317794938:ChildLearnEmailTopic')
                    ->begin()
            );
    }
}


if (!function_exists('createNewCloudfrontRemoteSegment')) {
    function createNewCloudfrontRemoteSegment()
    {
        Trace::getInstance()
            ->getCurrentSegment()
            ->addSubsegment(
                (new RemoteSegment())
                    ->setName('d2hmz1phin01an.cloudfront.net')
                    // ->setUrl('d2hmz1phin01an.cloudfront.net')
                    ->begin()
            );
    }
}

if (!function_exists('createNewSQLSegment')) {
    function createNewSQLSegment()
    {
        Trace::getInstance()
            ->getCurrentSegment()
            ->addSubsegment(
                (new SqlSegment())
                    ->setName('awseb-e-ecfp7dp5pn-stack-awsebrdsdatabase-3kt0ellbqgdt.c1cevqakx6ry.us-east-1.rds.amazonaws.com')
                    ->setUrl('awseb-e-ecfp7dp5pn-stack-awsebrdsdatabase-3kt0ellbqgdt.c1cevqakx6ry.us-east-1.rds.amazonaws.com')
                    ->setDatabaseType('MySQL Community')
                    // ->setQuery($query)
                    ->begin()
            );
    }
}

if (!function_exists('begin_CurrentSegment')) {
    function begin_CurrentSegment()
    {
        Trace::getInstance()
            ->getCurrentSegment()
            ->begin();
    }
}

if (!function_exists('end_CurrentSegment')) {
    function end_CurrentSegment()
    {
        Trace::getInstance()
            ->getCurrentSegment()
            ->end();

    }
}

if (!function_exists('set_SQLSegmentQuery')) {
    function set_SQLSegmentQuery($query)
    {
        Trace::getInstance()
            ->getCurrentSegment()
            ->setQuery($query);
    }
}

if (!function_exists('setTrace_ParendID')) {
    function setTrace_ParendID()
    {
        if (!isset($_SESSION['trace_id']) && !isset($_SESSION['parent_id'])) {
            echo "new trace session SET !";
            $_SESSION['trace_id'] = Trace::getInstance()->getTraceId();
            $_SESSION['parent_id'] = Trace::getInstance()->getId();
        }
    }
}

if (!function_exists('submitXrayTracing')) {
    function submitXrayTracing()
    {
        Trace::getInstance()
            ->end()
            ->setResponseCode(http_response_code())
            ->submit(new DaemonSegmentSubmitter());
        //Print the Trace ID
        print_r(Trace::getInstance());
    }
}