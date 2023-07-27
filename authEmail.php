<?php
use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;
require_once 'vendor/autoload.php';
require_once 'constant.php';


function sendVerificationEmail($userEmail, $token)
{   
    global $awsAccessKeyId, $awsSecretAccessKey;
    $sns = new SnsClient([
        'version' => 'latest',
        'region' => 'us-east-1', // Change this to your desired AWS region
    ]);

    $body = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTD-8">
        <title>Verify Email</title>
    </head>
    <body>
        <div class="wrapper">
            <p>
                <b>Welcome to ChildLearn!</b>
            </p>
            <p>
                Thank you for signing up on our website. Please click on the link below to verify your email.
            </p>
            <a href="http://childlearn-env-1.eba-49nd49e2.us-east-1.elasticbeanstalk.com/ChildLearn-sns/verification.php?token=' . $token .'">Verify your email address now</a>
        </div>
    </body>
    </html>'; 

    try {
    // Publish the email to the topic
    $result = $sns->publish([
        'TopicArn' => 'arn:aws:sns:us-east-1:941317794938:ChildLearnEmailTopic',
        'Message' => $body,
        'Subject' => 'Please verify your email address',
        'MessageAttributes' => [
            'email' => [
                'DataType' => 'String',
                'StringValue' => $userEmail,
            ],
            'token' => [
                'DataType' => 'String',
                'StringValue' => $token,
            ],
        ],
    ]);

    } catch (AwsException $e) {
        // Catch any AWS-related exceptions and log the error message
        $errorMessage = 'AWS Exception: ' . $e->getMessage();
        logError($errorMessage);
        // You can also choose to throw the exception again if you want to handle it further up the call stack.
        // throw $e;
    } catch (Exception $e) {
        // Catch any other exceptions (non-AWS related) and log the error message
        $errorMessage = 'Exception: ' . $e->getMessage();
        logError($errorMessage);
        // You can also choose to throw the exception again if you want to handle it further up the call stack.
        // throw $e;
    }
}

function sendPasswordResetLink($userEmail, $token)
{
    global $awsAccessKeyId, $awsSecretAccessKey;
    $sns = new SnsClient([
        'version' => 'latest',
        'region' => 'us-east-1', // Change this to your desired AWS region
    ]);

    $body = '
            Hello there, 

            Please click on the link below to reset your password.
          
            http://childlearn-env-1.eba-49nd49e2.us-east-1.elasticbeanstalk.com/ChildLearn-sns/verification.php?password-token=' . $token .'
            '; 

    try {
    // Publish the email to the topic
    $result = $sns->publish([
        'TopicArn' => 'arn:aws:sns:us-east-1:941317794938:ChildLearnEmailTopic',
        'Message' => $body,
        'Subject' => 'Reset your password',
        'MessageAttributes' => [
            'email' => [
                'DataType' => 'String',
                'StringValue' => $userEmail,
            ],
            'password-token' => [
                'DataType' => 'String',
                'StringValue' => $token,
            ],
        ],
    ]);  

    } catch (AwsException $e) {
        // Catch any AWS-related exceptions and log the error message
        $errorMessage = 'AWS Exception: ' . $e->getMessage();
        logError($errorMessage);
        // You can also choose to throw the exception again if you want to handle it further up the call stack.
        // throw $e;
    } catch (Exception $e) {
        // Catch any other exceptions (non-AWS related) and log the error message
        $errorMessage = 'Exception: ' . $e->getMessage();
        logError($errorMessage);
        // You can also choose to throw the exception again if you want to handle it further up the call stack.
        // throw $e;
    }
}



function subscribeEmail($userEmail, $token)
{
    $filterPolicy = [
        'email' => [$userEmail],
        'password-token' => [$token]
    ];

    $sns = new SnsClient([
        'version' => 'latest',
        'region' => 'us-east-1', // Change this to your desired AWS region
    ]);
    try {
        // Subscribe the endpoint to the topic
        $result = $sns->subscribe([
            'TopicArn' => 'arn:aws:sns:us-east-1:941317794938:ChildLearnEmailTopic',
            'Protocol' => 'email', // Use 'email' for email subscription
            'Endpoint' => $userEmail,
            'FilterPolicy' => json_encode($filterPolicy),
        ]);

        // Optionally, you can print the subscription ARN if needed
        $subscriptionArn = $result->get('SubscriptionArn');
    } catch (\Aws\Exception\AwsException $e) {
        // Handle the exception, log, or display the error message
        echo "Error: " . $e->getMessage() . "\n";
    }
}
