<?php
/**
 * Returns a direction for sorted queries between ASC and DESC, DESC being default if no $_POST has been submitted
 * @param void
 * @return string
 */
function filterForQuerySortingDirection()
{

    function validateDirection($value)
    {
        $availableDirections = ['DESC', 'ASC'];
        if (in_array($value, $availableDirections)) return $value;

        return 'DESC';
    }

    return filter_input(INPUT_POST, 'direction', FILTER_CALLBACK, ['options' => 'validateDirection']);
}

/**
 * Filters your $_POST for sql queries
 * @param string The variable for which you are checking
 * @param array Your array of acceptable queries
 * @param string The default you want if nothing fits
 * @return string
 */
function filterPostVariable($variableInPost, $acceptableEntries, $defaultValue)
{
    if (in_array($_POST[$variableInPost], $acceptableEntries)) return filter_input(INPUT_POST, $variableInPost);
    
    return $defaultValue;
}

function connect($host, $dbname, $login, $password){
    return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $login, $password);
}

function filter_input_array_with_default_flags($type, $filter, $flags, $add_empty = true) {
    $loopThrough = array();
    switch ($type) {
        case INPUT_GET : $loopThrough = $_GET; break;
        case INPUT_POST : $loopThrough = $_POST; break;
        case INPUT_COOKIE : $loopThrough = $_COOKIE; break;
        case INPUT_SERVER : $loopThrough = $_SERVER; break;
        case INPUT_ENV : $loopThrough = $_ENV; break;
    }
   
    $args = array();
    foreach ($loopThrough as $key=>$value) {
        $args[$key] = array('filter'=>$filter, 'flags'=>$flags);
    }
    
    return filter_input_array($type, $args, $add_empty);
}

?>