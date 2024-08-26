$(document).ready(function () {

    // Password Show&Hide
    $("#eyeBtn").click(function () {
        $("#eyeBtn i").toggleClass("fa-eye fa-eye-slash");
        if ($("#loginPwd").attr("type") == "password") {
            $("#loginPwd").attr("type", "text")
        } else {
            $("#loginPwd").attr("type", "password")
        }
    })
    $("#eyeConfirmBtn").click(function () {
        $("#eyeConfirmBtn i").toggleClass("fa-eye fa-eye-slash");
        if ($("#loginConfirmPwd").attr("type") == "password") {
            $("#loginConfirmPwd").attr("type", "text")
        } else {
            $("#loginConfirmPwd").attr("type", "password")
        }
    })

    // DateTime
    let months = [
        "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
    ];
    let date = new Date();
    let monthName = months[date.getMonth()]
    let currentDate = monthName + " " + date.getDate().toString() + " " + date.getFullYear().toString()
    $("#dateTime").html(currentDate)

    // DeleteSuccess
    $("#xmark").click(function () {
        location.reload()
    })

    // DarkModeBtn
    // $("#darkModeBtn").click(function () {
    //     $("#darkModeBtn i").toggleClass("fa-moon fa-sun")
    //     $("#navigatePanel").toggleClass("bg-white bg-dark")
    //     $("#navigations button").toggleClass("text-white")
    //     $("#mainContainer nav").toggleClass("bg-white bg-dark")
    //     $("#mainContainer small").toggleClass("text-white text-black")
    //     $("#mainBtnDropMenu").toggleClass("bg-dark")
    //     $("#subContainer").toggleClass("bg-dark")
    //     $("#subContainer").toggleClass("text-white")
    //     $("#calender").toggleClass("bg-white bg-dark")
    // })

})
