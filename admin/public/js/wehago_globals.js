/**
 * Wehago Object
 */
var setting = {
    "edupre" : {
        "CNO" : "1014873",
        "SELL_NO_BIZ" : "1058101773",
        "CNM" : "(주)꼬망세미디어",
    } ,
    "intourch" : {
        "CNO" : "1777096",
        "SELL_NO_BIZ" : "1058101773",
        "CNM" : "(주)인터치랩",
    } ,
    "test" : {
        "CNO" : "1731201",
        "SELL_NO_BIZ" : "2222222227",
        "CNM" : "테스트_WEHAGO 연동 ",
    } ,        
};


var keyInfo = {
    "app_key":"f6cc46f9cb9744f89fbae4391bf561c6",
    "service_code" : "edupre-media",
    "mode": "live"
    // "mode": "dev"
}
var wehago_globals = {
    service_code: keyInfo.service_code,   // 발급받은 코드
    mode : keyInfo.mode,   // dev-개발, live-운영
};


