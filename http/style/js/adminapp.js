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
       /**
     *  Select Student 
     */
    $(document).on('click', '.intelli-student div a', function (element) {
        var uid = $(this).data('uid');
        var nameStudent = $(this).data('name');
        var addInput = '<input name="uid[]" type="hidden" value="' + uid + '" />';
        $(this).closest('td').find('.uidSearch').val(nameStudent);
        // Control if uid exist
        var replaceUid = $(this).closest('td').find('input[name="uid[]"]');
        if (replaceUid.val()) {
            replaceUid.val(uid);
        } else {
            $(this).closest('td').append(addInput);
        }
        
        $('.intelli-student').empty();
    });
    
    
    
    $(document).on('keyup', '.uidSearch', function ($element) {
        $('.intelli-student').empty();
        if($(this).val().length <= 3 ){
            $(this).closest('td').find('input[name="uid[]"]').remove();
        }
        var activeIn = $(this);
        $.ajax({
            method: "POST",
            url: "/smps/admin/student/search",
            data: {search: $(this).val()}
        }).success(function (msg) {
            var result = '<div class="list-group">';
            var uidExist = $('input[name="uid[]"]').toArray();
            $.each(msg, function (index, value) {
                var doesUidExist = false;
                $.each(uidExist, function (indexExist, valueUID) {
                    if (valueUID['value'] == value.uid) {
                        doesUidExist = true;
                    }
                });

                if (doesUidExist == false) {
                    result += ' <a href="#" class="list-group-item" data-uid="' + value.uid + '" data-name="' + value.emri + " " + value.mbiemri + '">' + value.emri + " " + value.mbiemri + '</a>';
                }
            });
            result += "</div>";
            activeIn.closest('td').find('div').empty();
            activeIn.closest('td').find('div').append(result);
        }).done(function (msg) {
//                    alert("Data Saved: " + msg);
        });
    });
    $(document).on('keyup', '#searchPerson', function ($element) {
        $('.intelli-person').empty();
//        if($(this).val().length <= 3 ){
//            $(this).closest('td').find('input[name="uid[]"]').remove();
//        }
        
        var activeIn = $(this);
        $.ajax({
            method: "POST",
            url: "/smps/admin/student/search",
            data: {search: $(this).val()}
        }).success(function (msg) {
            var result = '';
            $.each(msg, function (index, value) {
                    result += '<li class="treeview"> <a href="/smps/admin/student/profile/'+value.uid+'"><i class="fa fa-circle-o text-aqua"></i>' + value.emri + " " + value.mbiemri + '</a></li>';
            });
//            result += "</div>";
            $('.intelli-person').empty();
            $('.intelli-person').append(result);
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