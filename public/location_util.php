 <?php
function getVisitorIpAddress() {   
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
        return $_SERVER['HTTP_CLIENT_IP']; 
    } 
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
        return $_SERVER['HTTP_X_FORWARDED_FOR']; 
    } 
    else { 
        return $_SERVER['REMOTE_ADDR']; 
    } 
} 

function getVisitorCountryCode() {
    $cip = getVisitorIpAddress();
    $iptolocation = 'http://ip-api.com/json/' . $cip;
    $visitor_info = @json_decode(file_get_contents($iptolocation));
    if ($visitor_info && isset($visitor_info->countryCode)) {
        return $visitor_info->countryCode;
    } else {
        return "NaN";
    }
}

?>