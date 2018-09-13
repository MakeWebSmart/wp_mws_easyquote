jQuery(document).ready(function ($) {
    // var arr = [2194,2000,2009,2011,2027,2030,2029,2028,2023,2025,2026,2022,2024,2021,2031,2033,2034,2052,2032,2018,2035,2019,2036,2020,2017,2016,2008,2010,2007,2006,2042,2043,2015,2044,2204,2049,2050,2037,2038,2040,2039,2041,2047,2046,2045,2130,2049,2203,2205,2216,2217,2219,2231,2229,2228,2224,2232,2226,2225,2221,2218,2207,2220,2222,2223,2208,2209,2206,2193,2133,2131,2132,2134,2137,2140,2129,2139,2138,2127,2110,2111,2135,2136,2191,2192,2190,2141,2196,2210,2234,2211,2212,2213,2200,2199,2143,2144,2128,2142,2150,2160,2161,2162,2197,2199,2214,2163,2172,2173,2167,2564,2170,2166,2165,2164,2145,2152,2117,2116,2115,2114,2112,2113,2066,2167,2054,2068,2063,2062,2085,2060,2061,2089,2088,2090,2092,2094,2095,2061],
//    var arr = ['2194','2000',2009],
    modelStr = false,
    modelObj = false,
    price = 0;
    issue1price = 0;
    issue2price = 0,
    issue3price = 0,
    easyquotestr1 = '';
    easyquotestr2 = '';
    easyquotestr3 = '';
    labelID = false;


//     $('#form1 input').keyup(function (e) {
//         var found = false;
//             if(e.target.value.length == 4){
// //            console.log('length 4 called');
//                 arr.forEach(function (v) {
//                     if (v == e.target.value) {
// //                        console.log('Value Matched');
//                         found = true;
//                         $("#form1 input[name=next]").prop("disabled", false);
//                     }
//                 })
//                 if(found === false){
//                     $("#form1 input[name=next]").prop("disabled", true);
//                     alert('Sorry, Online easyquote is not available in this area. Please call us on (02) 8386 8873 for easyquote Over the Phone.');
//                 }
//             }
//     })


    $('#form2 label.wpir_field_input').click(function() {
        $("#form2 input[type=button]").prop("disabled", false);
        var labelID = $(this).attr('for');
        if(dataObj !== undefined && dataObj){
            modelObj = dataObj['models'][labelID]; 
            // console.log('modelSelected')
            // console.log(modelObj)
            modelStr = 'Model Selected: <span>' + modelObj.modelname + '</span>'
            $('#modelid').val(labelID);
            if(modelObj.issue1name !== undefined && modelObj.issue1name){
                // console.log('issue1name')
                // console.log(modelObj.issue1name)
                $('#inputissue1').val(modelObj.issue1price);
                $('#priceissue1').html(modelObj.issue1price);
                $('.labelissue1').html(modelObj.issue1name);
            }
            if(modelObj.issue2name !== undefined && modelObj.issue2name){
                // console.log(modelObj.issue2name)
                $('#inputissue2').val(modelObj.issue2price);
                $('#priceissue2').html(modelObj.issue2price);
                $('.labelissue2').html(modelObj.issue2name);
            }
            if(modelObj.issue3name !== undefined && modelObj.issue3name){
                // console.log(modelObj.issue3name)
                $('#inputissue3').val(modelObj.issue3price);
                $('#priceissue3').html(modelObj.issue3price);
                $('.labelissue3').html(modelObj.issue3name);
            }
            $('#modelname').html(modelStr);
            $('#modelname2').html(modelStr);
            $('#modelname3').html(modelStr);
        }
    });
    
    $("#form2 li").click(function () {
        $("#form2 ul li").removeClass('clicked');
        $(this).addClass('clicked');

    });
        
     $('#form3 input[type=checkbox]').click(function(e) {
         var form3val1 = false
         var form3val2 = false
         var form3val3 = false

        if ($('input#inputissue1').is(':checked')) {
            $('input#inputissue1').val(modelObj.issue1price);
            easyquotestr1 = modelObj.issue1name + ' problem cost: ' + modelObj.issue1price + '. ';
            $('#issuename1').html(easyquotestr1);
            issue1price = parseInt(modelObj.issue1price);
            form3val1 = true
        } else {
            easyquotestr1 = ''
            issue1price = 0;
            $('#issuename1').html('');
            $('input#inputissue1').val();
            form3val1 = false
        }

        if ($('input#inputissue2').is(':checked')) {
            $('input#inputissue2').val(modelObj.issue2price);
            easyquotestr2 = modelObj.issue2name + '  problem cost: ' + modelObj.issue2price + '. ';
            $('#issuename2').html(easyquotestr2);
            issue2price = parseInt(modelObj.issue2price);
            form3val2 = true
        } else {
            easyquotestr2 = ''
            issue2price = 0;
            $('#issuename2').html('');
            $('input#inputissue2').val();
            form3val2 = false
        }

        if ($('input#inputissue3').is(':checked')) {
            $('input#inputissue3').val(modelObj.issue3price);
            easyquotestr3 = modelObj.issue3name + ' problem cost: ' + modelObj.issue3price + '. ';
            $('#issuename3').html(easyquotestr3);
            issue3price = parseInt(modelObj.issue3price);
            form3val3 = true
        } else {
            easyquotestr3 = ''
            issue3price = 0;
            $('#issuename3').html('');
            $('input#inputissue3').val();
            form3val3 = false
        }

        if(form3val1 === false && form3val2 === false && form3val3 === false){
            $("#form3 input[name=next]").prop("disabled", true);
        } else {
            price = issue1price + issue2price + issue3price;
            $('#totalcost').html('Total price: ' + price );
            $("#form3 input[name=next]").prop("disabled", false);
            var infostr = ' Total Price: ' + price + '. ' + modelStr + ' ' + easyquotestr1 + ' ' + easyquotestr2 + ' ' + easyquotestr3;
            $("#form5 input[name=info]").val(infostr);
            
        }
        // console.log(price,issue1price,issue2price,issue3price);
     });
});