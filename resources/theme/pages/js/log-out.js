/*=========================================================================================
  File Name: auth-reset-password.js
  Description: Auth reset password js file.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: PIXINVENT
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
    'use strict';

    $(".dropdown-menu .logout").click(function (e) {
        e.preventDefault()
        $.ajax({
            type:'post',
            url:$(this).attr('href')
        }).then(function (response) {
            window.location.reload();
        })
    })
});
