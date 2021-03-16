#!/usr/bin/php
<?php
/*
 * Usage: ./index.php < number of words > < length of words > < --force? >
 */


try {
    /*
     * $argv[1] - letter count
     * $argv[2] - word count
     * $argv[3] - optional '--force' flag
     */
    $isForced = in_array($argv[3], ['--force']);
    if ($argc === 3 || ($argc === 4 && $isForced)) {
        /* create log record */
        createLog($argv[1], $argv[2]);
        /* parse letter count argument to array */
        $letterQuantity = parseLetterQuantity($argv[1]);

        /* check if date is ok */
        $currentDate = getDate();
        if (!checkDateTime($currentDate, $isForced)) {
            echo 'You can\'t use this script now';
            return;
        }

        /* check if all arguments can be converted to int (except '--force' flag)*/
        if (!(ctype_digit($argv[2]) && ctype_digit($letterQuantity[0]) && ctype_digit($letterQuantity[1]))) {
            throw new UnexpectedValueException("argument can't be converted to int");
        }

        /* create words */
        require_once './src/WordGenerator.php';
        $wordGenerator = new WordGenerator((int)$letterQuantity[0], (int)$letterQuantity[1]);
        for ($i = 0; $i < $argv[2]; $i++) {
            $wordGenerator->createWord();
        }
    } else {
        echo 'Usage: ./index.php < --force? > < number of words > < length of words >';
    }
} catch (Exception $exception) {
    createExceptionLog($exception);
    echo 'an error occured: '.$exception->getMessage()."\n";
}



/**
 * function checks if current date is between given boundaries
 * @param $date - array with date
 * @param $isForced - state of flag '--forced'
 * @return false if date boundaries are violeted, true if not
 **/
function checkDateTime($date, $isForced): bool {
    /* always return true if flag is raised */
    if ($isForced) return true;
    $weekday = $date['wday'];
    $hour = $date['hours'];
    /* check inner */
    if($weekday > 5){
        return false;
    }
    /* check boundaries */
    else if ( ($weekday === 5 and $hour > 15) or ($weekday === 1 and $hour < 10 ) ){
        return false;
    }
    return true;
}


/**
 * @param string $span - two numbers split with '-'
 * @return false|string[] - returns parsed numbers or throw UnexpectedValueException|InvalidArgumentException
 */
function parseLetterQuantity(string $span)
{
    $args = explode('-', $span);
    if (!($args[0] === '' && $args[1] === '')) {
        if (count($args) === 2) {
            if ($args[0] === '') $args[0] = '1';
            else if ($args[1] === '') $args[1] = $args[0];

            if($args[1] < $args[0]) throw new InvalidArgumentException('Upper bound is greater than Lower bound ');
            return $args;
        }
    }
    throw new UnexpectedValueException('cannot convert boundaries');
}

/**
 * function records new log from running script
 * @param $letterQuantity - max count of letters per word
 * @param $wordsQuantity - max count of words
 */
function createLog($letterQuantity, $wordsQuantity) {
    $date = date("Y-m-d H:i:s");
    $log = 'date of execution: '.$date.'
    number of letters in word: '.$letterQuantity.'
    number of words:'.$wordsQuantity."\n";

    file_put_contents('./generate.log', $log, FILE_APPEND);
}

/**
 * functions records new log when exception occurs
 * @param Exception $exception - thrown exception
 */
function createExceptionLog(Exception $exception) {
    $date = date("Y-m-d H:i:s");
    $log = 'date of execution: '.$date.'
    message: '.$exception->getMessage().'
    stack trace: '.$exception->getTraceAsString()."\n";

    file_put_contents('./exceptions.log', $log, FILE_APPEND);
}
