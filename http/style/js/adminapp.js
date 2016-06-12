/*
 To change this license header, choose License Headers in Project Properties.
 To change this template file, choose Tools | Templates
 and open the template in the editor.
 */
/* 
 Created on : Dec 6, 2015, 8:57:15 PM
 Author     : Alban_Mulaki
 */
$(document).ready(function () {

//    $(document).mouseup(function(e){
//    });
//$(document).click(function(){
//        $('.intelli-student').empty();
//});
//    $(document).on('onmouseout','.intelli-student',function(){
//        alert($(this).data('uid'));
//        $('.intelli-student').empty();
//    });
//    $(document).on('onmouseout','.intelli-student div a',function(){
//        alert($(this).data('uid'));
//    });
    /**
     *  Select Student 
     */
    $(document).on('click', '.intelli-student div a', function (element) {
        var uid = $(this).data('uid');
        $('.intelli-student').empty();
        var addInput = '<input name="uid[]" type="hidden" value="' + uid + '" />';
//        $('input=["text"]')
        
//        var uidExist = $('input[name="uid[]"]').val();
//        alert(uidExist);
//        alert(uid);
//        if(uidExist == uid){
//            alert("Exist");
//        }
        
        
        $('#submitRaport').append(addInput);
        $(this).closest('td').find('.uidSearch').val('AAAAA');
    });
    /**
     * Search Student
     */
    $(document).on('keyup', '.uidSearch', function ($element) {
        $('.intelli-student').empty();
        var activeIn = $(this);
        $.ajax({
            method: "POST",
            url: "/smps/admin/student/search",
            data: {search: $(this).val()}
        }).success(function (msg) {
            var result = '<div class="list-group">';
            
            var uidExist = $('input[name="uid[]"]').toArray();
            alert(uidExist[0]);
            $.each(msg, function (index, value) {
                var doesUidExist = false;
                $.each(uidExist,function(indexExist,valueUID){
                    if( valueUID == value.uid ){
                        doesUidExist = true;
                    }
                });
                if(doesUidExist == false){
                    result += ' <a href="#" class="list-group-item" data-uid="' + value.uid + '">' + value.emri + " " + value.mbiemri + '</a>';
                }
            });
            result += "</div>";
            activeIn.closest('td').find('div').empty();
            activeIn.closest('td').find('div').append(result);
        }).done(function (msg) {
//                    alert("Data Saved: " + msg);
        });
    });


    var ESC = 27;

    $(document).on('keyup', document, function (e) {
        if (e.keyCode == ESC) { // escape key maps to keycode `27`
            $('.intelli-student').empty();
        }
    });
    
    $(document).on('keydown', document, function (e) {
        if (e.keyCode == ESC) { // escape key maps to keycode `27`
            $('.intelli-student').empty();
        }
    });


    $('#addNewRow').on('click', function () {
        var elemNum = $(document).find("input[name*='uid_']");
        console.log(elemNum.length);
        var name_surname = "<td>" + $('<input>').attr('name', 'name_surname[]').attr('class', 'form-control input-sm').attr('type', 'text').prop('outerHTML') + "</td>";
        var uid = "<td>" + $('<input>').attr('name', 'uid[]').attr('class', 'form-control input-sm').attr('type', 'text').prop('outerHTML') + "</td>";
        var test_semestral = "<td>" + $('<input>').attr('name', 'test_semestral[]').attr('class', 'form-control input-sm').attr('type', 'text').prop('outerHTML') + "</td>";
        var testi_gjysemsemestral = "<td>" + $('<input>').attr('name', 'testi_gjysemsemestral[]').attr('class', 'form-control input-sm').attr('type', 'text').prop('outerHTML') + "</td>";

        var seminari = "<td>" + $('<input>').attr('name', 'seminari[]').attr('class', 'form-control input-sm').attr('type', 'text').prop('outerHTML') + "</td>";

        var pjesmarrja = "<td>" + $('<input>').attr('name', 'pjesmarrja[]').attr('class', 'form-control input-sm').attr('type', 'text').prop('outerHTML') + "</td>";

        var praktike = "<td>" + $('<input>').attr('name', 'praktike[]').attr('class', 'form-control input-sm').attr('type', 'text').prop('outerHTML') + "</td>";

        var testi_final = "<td>" + $('<input>').attr('name', 'testi_final[]').attr('class', 'form-control input-sm').attr('type', 'text').prop('outerHTML') + "</td>";

        var nota = "<td>" + $('<input>').attr('name', 'nota[]').attr('class', 'form-control input-sm').attr('type', 'text').prop('outerHTML') + "</td>";

        var refuzim = "<td> <select name='refuzim[]' class='input-sm'><option value='1'>PO</option><option value='0'>JO </option> </select></td>";

        var paraqit = "<td> <select name='paraqit[]' class='input-sm'><option value='1'>PO</option><option value='0'>JO </option> </select></td>";

        var present = "<td> <select name='paraqit_prezent[]' class='input-sm'><option value='1'>PO </option><option value='0'>JO </option> </select></td>";


        var contentTd = name_surname +
                uid +
                test_semestral +
                testi_gjysemsemestral +
                seminari +
                pjesmarrja +
                praktike +
                testi_final +
                nota +
                refuzim +
                paraqit +
                present;
        $('#raportiNotaveTable tr:last').before("<tr class='info'>" + contentTd + "</tr>").fadeIn('slow');

    });
});