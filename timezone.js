$(document).ready(function() {

    //Returns no of min ahead/behind greenwich meridian
    var offset = new Date().getTimezoneOffset();
    

    //Returns no of millisecs since 1970/01/01
    var timestamp = new Date().getTime();
    

    //Convert time to: universal time coordinated / universal coordinated time
    var utc_timestamp = timestamp + (60000 * offset);
    

    $('#time_zone_offset').val(offset);
    $('#utc_timestamp').val(utc_timestamp);

});