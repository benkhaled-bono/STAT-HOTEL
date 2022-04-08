$(document).ready(function()
{
    'use strict';

   // // Dashboard /* #074 - Dashboard - Change Layout & Add Icons*/

    // $('.toggle-info').click(function (){

    //     $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(150); 

    //     if($(this).hasClass('selected')) {

    //         $(this).html('<i class="fa fa-minus fa-lg"></i>');
        
    //     }else {

    //         $(this).html('<i class="fa fa-plus fa-lg"></i>');

    //     }

    // });


    // //  #062 - Plugins - Add SelectBoxIt Plugin
    // // Calls the selectBoxIt method on your HTML select box and uses the default theme
    // $("select").selectBoxIt({

    //     autoWidth : false
    // });
              
    // // Hide Placeholder on Form Input Function
    // $('[placeholder]').focus(function() { $(this).attr('data-text', $(this).attr('placeholder')); $(this).attr('placeholder', '');})   
    // .blur(function() { $(this).attr('placeholder', $(this).attr('data-text'));});

 
    // // #25 Add Asterisk On Required Field
    // $('input').each(function () {
    //     if ($(this).attr('required') === 'required')
        
    //     { $(this).after('<span class="asterisk">*</span>'); } });


    // // #27 Convert pasword field to text field on Hover
    // var passfield = $('.password');

    // $('.show-pass').hover(function () { passfield.attr('type', 'text');},

    // function () { passfield.attr('type', 'password');} 
    
    //                     );
    
    // // Confirmation Deleting Message

    // $('.confirm').click(function () {

    //     return confirm('Are you sure to Delete this User');

    // });

    // // #58 Category View Option

    // $('.cat h3').click(function(){

    //     $(this).next('.full-view').fadeToggle(200);

    // });

    // $('.option span').click(function(){
    
    //     $(this).addClass('active').siblings('span').removeClass('active'); 

    //     if ($(this).data('view') === 'full') {

    //         $('.cat .full-view').fadeIn(200)
    //     }
    //     else {

    //         $('.cat .full-view').fadeOut(200)
    //     }
    
    // });    
        


}); 