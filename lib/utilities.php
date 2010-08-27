<?php 
/*
    Sourdough Utilities

    01 - plural
    02 - get_relative_date
*/

/*
    Returns "s" unless $num is "1"
    Used by `relative_date`.
*/
function plural( $num ) {
    if ($num != 1)
        return "s";
}

/*
    Returns relative(more human) date string.
    Uses `plural`.

    Usage:
    `get_relative_date(get_the_date())`
*/
function get_relative_date( $date ) {
    $diff = time() - strtotime($date);
    if ($diff < 60)
        return $diff." second".plural($diff)." ago";
    $diff = round($diff / 60);
    if ($diff < 60)
        return $diff." minute".plural($diff)." ago";
    $diff = round($diff / 60);
    if ($diff < 24)
        return $diff." hour".plural($diff)." ago";
    $diff = round($diff / 24);
    if ($diff < 7)
        return $diff." day".plural($diff)." ago";
    $diff = round($diff / 7);
    if ($diff < 4)
        return $diff." week".plural($diff)." ago";
    return "on ".date("F j, Y", strtotime($date));
}
?>