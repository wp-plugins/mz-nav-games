<?php
function mZ_nav_games_show_dates( $atts )
{
    $mz_date = empty($_GET['mz_date']) ? date_i18n('Y-m-d') : mz_ng_validate_date($_GET['mz_date']);
    $result = '<br/>';
	$mz_timeframe = array_slice(mz_ng_getDateRange($mz_date), 0, 1);
	$mz_timeframe = array_pop($mz_timeframe);
    $result .= mz_nav_games_schedule_nav($mz_date);
    $result .= '<div style="border:1px solid blue">';
    $result .= '<br/> This week begins on <b>'. $mz_timeframe['StartDateTime'];
    $result .= '</b> and ends on <b>'. $mz_timeframe['EndDateTime']. '</b>';
    $result .= '<style type="text/css">';
    $result .= 'tr:nth-child(even) {background: #CCC}';
    $result .= 'tr:nth-child(odd) {background: #FFF}';
    $result .= 'table {border-spacing: 10px;border-collapse: separate;}';
    $result .= 'td {padding: 10px;}';
    $result .= '</style>';
    $result .= mz_ng_display_dates($mz_timeframe);
    $result .= '</div>';
    return $result;
}//EOF mZ_games_show_dates

function mz_ng_display_dates($timeframe, $duration=7) {
    /*
    Accepts an array with start and end times and outputs string containing html table display
    adapted from http://stackoverflow.com/questions/186431/calculating-days-of-week-given-a-week-number
    */
    list($year, $month, $day) = explode("-", $timeframe['StartDateTime']);
    
    // Timestamp of the monday for that week
    $date = mktime('0','0','0', $month, $day, $year);

    $seconds_in_a_day = 86400;
    $result = '<table>';
    // Get date for 7 days from Monday (inclusive)
    for($i=0; $i < $duration; $i++)
    {
        $day = date('Y-m-d',$date+($seconds_in_a_day*$i));
        $result    .= '<tr><td>'.date('l dS \o\f F Y', strtotime($day)).'</td></tr>';
    }
    $result .= '</table>';
    return $result;
}

function mz_nav_XXX_games_schedule_nav($mz_get_variables)
{
	$sched_nav = '';
	$mz_schedule_page = get_permalink();
	//sanitize input
	//set week number based on php date or passed parameter from $_GET
	$mz_date = empty($mz_get_variables['mz_date']) ? date_i18n('Y-m-d') : mz_ng_validate_date($mz_get_variables['mz_date']);
	//Navigate through the weeks
	$mz_start_end_date = mz_ng_getDateRange($mz_date);
	$mz_nav_weeks_text_prev = __('Previous Week');
	$mz_nav_weeks_text_current = __('Current Week');
	$mz_nav_weeks_text_following = __('Following Week');
	$sched_nav .= ' <a href='.add_query_arg(array('mz_date' => ($mz_start_end_date[3]))).'>'.$mz_nav_weeks_text_prev.'</a>';
	$sched_nav .= ' - <a href='.$mz_schedule_page.'>'.$mz_nav_weeks_text_current.'</a> - ';
	$sched_nav .= '<a href='.add_query_arg(array('mz_date' => ($mz_start_end_date[2]))).'>'.$mz_nav_weeks_text_following.'</a>';

	$mz_timeframe = array('StartDateTime'=>$mz_start_end_date[0], 'EndDateTime'=>$mz_start_end_date[1], 'SchedNav'=>$sched_nav);

	return $mz_timeframe;
}
?>
