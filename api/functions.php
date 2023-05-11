<?php
// verfiy data type 
function regexCheck($item,$type) {
    if(empty($item) && $item !=0)
    {
        return false;
    }
    $regex = NULL;
    if ($type == 'text')
    {
        $regex = '/^.+$/';
    }  elseif ( $type == 'number')
    {
        $regex = '/^-?\d+$/';
    }
    if(!$regex)
    {
        return null;
    }
    return preg_match($regex,$item);
}
?>