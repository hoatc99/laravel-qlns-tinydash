"use strict";

//Sidebar toggle set state

let value = localStorage.getItem("sidebarCollapsed");

if (value == "true") {
    $("body").addClass("collapsed");
}

$(".collapseSidebar").click(function () {
    value = $("body").hasClass("collapsed");
    localStorage.setItem("sidebarCollapsed", value);
});

//Sidebar items set state

$(function () {
    let url = window.location.origin + window.location.pathname;
    $("a").each(function () {
        if (this.href === url) {
            $(this).addClass("active");
            $(this).closest("ul").addClass("show");
            $(this).closest("li.nav-item").addClass("active");
            $(this).closest(".dropdown").addClass("active");
        }
    });
});

$(".modal").on("shown.bs.modal", function () {
    $(this).find("[autofocus]").focus();
});
