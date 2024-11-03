"use strict";

var logoHeaderContent = $(".sidebar .logo-header").html();
$(".main-header .logo-header").html(logoHeaderContent);

$(".nav-search .input-group > input")
    .focus(function (e) {
        $(this).parents().eq(2).addClass("focus");
    })
    .blur(function (e) {
        $(this).parents().eq(2).removeClass("focus");
    });

$(function () {
    // Show Tooltip
    const tooltipTriggerList = document.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
    );
    const tooltipList = [...tooltipTriggerList].map(
        (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
    );
    // Show Popover
    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    );
    const popoverList = [...popoverTriggerList].map(
        (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
    );
    layoutsColors();
    customBackgroundColor();
});

function layoutsColors() {
    if ($(".sidebar").is("[data-background-color]")) {
        $("html").addClass("sidebar-color");
    } else {
        $("html").removeClass("sidebar-color");
    }
}

function customBackgroundColor() {
    $('*[data-background-color="custom"]').each(function () {
        if ($(this).is("[custom-color]")) {
            $(this).css("background", $(this).attr("custom-color"));
        } else if ($(this).is("[custom-background]")) {
            $(this).css(
                "background-image",
                "url(" + $(this).attr("custom-background") + ")"
            );
        }
    });
}

function legendClickCallback(event) {
    event = event || window.event;

    var target = event.target || event.srcElement;
    while (target.nodeName !== "LI") {
        target = target.parentElement;
    }
    var parent = target.parentElement;
    var chartId = parseInt(parent.classList[0].split("-")[0], 10);
    var chart = Chart.instances[chartId];
    var index = Array.prototype.slice.call(parent.children).indexOf(target);

    chart.legend.options.onClick.call(
        chart,
        event,
        chart.legend.legendItems[index]
    );
    if (chart.isDatasetVisible(index)) {
        target.classList.remove("hidden");
    } else {
        target.classList.add("hidden");
    }
}

$(document).ready(function () {
    $(".btn-refresh-card").on("click", function () {
        var e = $(this).parents(".card");
        e.length &&
            (e.addClass("is-loading"),
            setTimeout(function () {
                e.removeClass("is-loading");
            }, 3e3));
    });

    var scrollbarDashboard = $(".sidebar .scrollbar");
    if (scrollbarDashboard.length > 0) {
        scrollbarDashboard.scrollbar();
    }

    var contentScrollbar = $(".main-panel .content-scroll");
    if (contentScrollbar.length > 0) {
        contentScrollbar.scrollbar();
    }

    var messagesScrollbar = $(".messages-scroll");
    if (messagesScrollbar.length > 0) {
        messagesScrollbar.scrollbar();
    }

    var tasksScrollbar = $(".tasks-scroll");
    if (tasksScrollbar.length > 0) {
        tasksScrollbar.scrollbar();
    }

    var quickScrollbar = $(".quick-scroll");
    if (quickScrollbar.length > 0) {
        quickScrollbar.scrollbar();
    }

    var messageNotifScrollbar = $(".message-notif-scroll");
    if (messageNotifScrollbar.length > 0) {
        messageNotifScrollbar.scrollbar();
    }

    var notifScrollbar = $(".notif-scroll");
    if (notifScrollbar.length > 0) {
        notifScrollbar.scrollbar();
    }

    var quickActionsScrollbar = $(".quick-actions-scroll");
    if (quickActionsScrollbar.length > 0) {
        quickActionsScrollbar.scrollbar();
    }

    var userScrollbar = $(".dropdown-user-scroll");
    if (userScrollbar.length > 0) {
        userScrollbar.scrollbar();
    }

    $("#search-nav").on("shown.bs.collapse", function () {
        $(".nav-search .form-control").focus();
    });

    var toggle_sidebar = false,
        toggle_quick_sidebar = false,
        toggle_topbar = false,
        minimize_sidebar = false,
        first_toggle_sidebar = false,
        toggle_page_sidebar = false,
        toggle_overlay_sidebar = false,
        nav_open = 0,
        quick_sidebar_open = 0,
        topbar_open = 0,
        mini_sidebar = 0,
        page_sidebar_open = 0,
        overlay_sidebar_open = 0;

    if (!toggle_sidebar) {
        var toggle = $(".sidenav-toggler");

        toggle.on("click", function () {
            if (nav_open == 1) {
                $("html").removeClass("nav_open");
                toggle.removeClass("toggled");
                nav_open = 0;
            } else {
                $("html").addClass("nav_open");
                toggle.addClass("toggled");
                nav_open = 1;
            }
        });
        toggle_sidebar = true;
    }

    if (!quick_sidebar_open) {
        var toggle = $(".quick-sidebar-toggler");

        toggle.on("click", function () {
            if (nav_open == 1) {
                $("html").removeClass("quick_sidebar_open");
                $(".quick-sidebar-overlay").remove();
                toggle.removeClass("toggled");
                quick_sidebar_open = 0;
            } else {
                $("html").addClass("quick_sidebar_open");
                toggle.addClass("toggled");
                $('<div class="quick-sidebar-overlay"></div>').insertAfter(
                    ".quick-sidebar"
                );
                quick_sidebar_open = 1;
            }
        });

        $(".wrapper").mouseup(function (e) {
            var subject = $(".quick-sidebar");

            if (
                e.target.className != subject.attr("class") &&
                !subject.has(e.target).length
            ) {
                $("html").removeClass("quick_sidebar_open");
                $(".quick-sidebar-toggler").removeClass("toggled");
                $(".quick-sidebar-overlay").remove();
                quick_sidebar_open = 0;
            }
        });

        $(".close-quick-sidebar").on("click", function () {
            $("html").removeClass("quick_sidebar_open");
            $(".quick-sidebar-toggler").removeClass("toggled");
            $(".quick-sidebar-overlay").remove();
            quick_sidebar_open = 0;
        });

        quick_sidebar_open = true;
    }

    if (!toggle_topbar) {
        var topbar = $(".topbar-toggler");

        topbar.on("click", function () {
            if (topbar_open == 1) {
                $("html").removeClass("topbar_open");
                topbar.removeClass("toggled");
                topbar_open = 0;
            } else {
                $("html").addClass("topbar_open");
                topbar.addClass("toggled");
                topbar_open = 1;
            }
        });
        toggle_topbar = true;
    }

    if (!minimize_sidebar) {
        var minibutton = $(".toggle-sidebar");
        if ($(".wrapper").hasClass("sidebar_minimize")) {
            minibutton.addClass("toggled");
            minibutton.html('<i class="gg-more-vertical-alt"></i>');
            mini_sidebar = 1;
        }

        minibutton.on("click", function () {
            if (mini_sidebar == 1) {
                $(".wrapper").removeClass("sidebar_minimize");
                minibutton.removeClass("toggled");
                minibutton.html('<i class="gg-menu-right"></i>');
                mini_sidebar = 0;
            } else {
                $(".wrapper").addClass("sidebar_minimize");
                minibutton.addClass("toggled");
                minibutton.html('<i class="gg-more-vertical-alt"></i>');
                mini_sidebar = 1;
            }
            $(window).resize();
        });
        minimize_sidebar = true;
        first_toggle_sidebar = true;
    }

    if (!toggle_page_sidebar) {
        var pageSidebarToggler = $(".page-sidebar-toggler");

        pageSidebarToggler.on("click", function () {
            if (page_sidebar_open == 1) {
                $("html").removeClass("pagesidebar_open");
                pageSidebarToggler.removeClass("toggled");
                page_sidebar_open = 0;
            } else {
                $("html").addClass("pagesidebar_open");
                pageSidebarToggler.addClass("toggled");
                page_sidebar_open = 1;
            }
        });

        var pageSidebarClose = $(".page-sidebar .back");

        pageSidebarClose.on("click", function () {
            $("html").removeClass("pagesidebar_open");
            pageSidebarToggler.removeClass("toggled");
            page_sidebar_open = 0;
        });

        toggle_page_sidebar = true;
    }

    if (!toggle_overlay_sidebar) {
        var overlaybutton = $(".sidenav-overlay-toggler");
        if ($(".wrapper").hasClass("is-show")) {
            overlay_sidebar_open = 1;
            overlaybutton.addClass("toggled");
            overlaybutton.html('<i class="icon-options-vertical"></i>');
        }

        overlaybutton.on("click", function () {
            if (overlay_sidebar_open == 1) {
                $(".wrapper").removeClass("is-show");
                overlaybutton.removeClass("toggled");
                overlaybutton.html('<i class="icon-menu"></i>');
                overlay_sidebar_open = 0;
            } else {
                $(".wrapper").addClass("is-show");
                overlaybutton.addClass("toggled");
                overlaybutton.html('<i class="icon-options-vertical"></i>');
                overlay_sidebar_open = 1;
            }
            $(window).resize();
        });
        minimize_sidebar = true;
    }

    $(".sidebar")
        .mouseenter(function () {
            if (mini_sidebar == 1 && !first_toggle_sidebar) {
                $(".wrapper").addClass("sidebar_minimize_hover");
                first_toggle_sidebar = true;
            } else {
                $(".wrapper").removeClass("sidebar_minimize_hover");
            }
        })
        .mouseleave(function () {
            if (mini_sidebar == 1 && first_toggle_sidebar) {
                $(".wrapper").removeClass("sidebar_minimize_hover");
                first_toggle_sidebar = false;
            }
        });

    // addClass if nav-item click and has subnav

    $(".nav-item a").on("click", function () {
        if ($(this).parent().find(".collapse").hasClass("show")) {
            $(this).parent().removeClass("submenu");
        } else {
            $(this).parent().addClass("submenu");
        }
    });

    //Chat Open
    $(".messages-contact .user a").on("click", function () {
        $(".tab-chat").addClass("show-chat");
    });

    $(".messages-wrapper .return").on("click", function () {
        $(".tab-chat").removeClass("show-chat");
    });

    //select all
    $('[data-select="checkbox"]').change(function () {
        var target = $(this).attr("data-target");
        $(target).prop("checked", $(this).prop("checked"));
    });

    //form-group-default active if input focus
    $(".form-group-default .form-control")
        .focus(function () {
            $(this).parent().addClass("active");
        })
        .blur(function () {
            $(this).parent().removeClass("active");
        });
});

// Input File Image

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(input)
                .parent(".input-file-image")
                .find(".img-upload-preview")
                .attr("src", e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$('.input-file-image input[type="file"').change(function () {
    readURL(this);
});

// Show Password

function showPassword(button) {
    var inputPassword = $(button).parent().find("input");
    if (inputPassword.attr("type") === "password") {
        inputPassword.attr("type", "text");
    } else {
        inputPassword.attr("type", "password");
    }
}

$(".show-password").on("click", function () {
    showPassword(this);
});

// Sign In & Sign Up
var containerSignIn = $(".container-login"),
    containerSignUp = $(".container-signup"),
    showSignIn = true,
    showSignUp = false;

function changeContainer() {
    if (showSignIn == true) {
        containerSignIn.css("display", "block");
    } else {
        containerSignIn.css("display", "none");
    }

    if (showSignUp == true) {
        containerSignUp.css("display", "block");
    } else {
        containerSignUp.css("display", "none");
    }
}

$("#show-signup").on("click", function () {
    showSignUp = true;
    showSignIn = false;
    changeContainer();
});

$("#show-signin").on("click", function () {
    showSignUp = false;
    showSignIn = true;
    changeContainer();
});

changeContainer();

//Input with Floating Label

$(".form-floating-label .form-control").keyup(function () {
    if ($(this).val() !== "") {
        $(this).addClass("filled");
    } else {
        $(this).removeClass("filled");
    }
});

function updateFileName() {
    const input = document.getElementById("file-input");
    const fileName = input.files[0] ? input.files[0].name : "Choose File";
    document.getElementById("file-name").textContent = fileName;
}
document.querySelectorAll(".dropdown-item").forEach((item) => {
    item.addEventListener("click", function () {
        // Remove 'active' class from all dropdown items
        document
            .querySelectorAll(".dropdown-item")
            .forEach((i) => i.classList.remove("active"));
        // Add 'active' class to the clicked item
        item.classList.add("active");
    });
});

$(document).ready(function () {
    // An array of Users table IDs or classes
    var userTables = [
        "#basic-datatables",
        "#basic-datatables_2",
        "#basic-datatables_3",
        "#basic-datatables_4",
    ];

    // An array of File table IDs or classes
    var fileTables = [
        "#file-datatables_1",
        "#file-datatables_2",
        "#file-datatables_3",
    ];

    var viewTables = [
        "#basic-datatables-view",
        "#basic-datatables-view-1",
        "#basic-datatables-view-2",
    ];

    var userDeletedTables = ["#userDeleted-datatables_1"];

    var fileDeletedTables = ["#fileDeleted-datatables_1"];

    // Common DataTable configuration
    var dataTableConfigUser = {
        paging: true, // Enable pagination
        searching: true, // Enable searching
        ordering: true, // Enable column ordering
        lengthMenu: [10, 20, 50, 70, 100],
        fixedHeader: true,
        responsive: true,
        dom:
            '<"row"<"col-md-6"l><"col-md-6 d-flex justify-content-end"fB>>' +
            '<"row"<"col-md-12"t>>' +
            '<"row"<"col-md-6"i><"col-md-6"p>>',
        buttons: [
            {
                extend: "csv",
                className: "btn btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "excel",
                title: "Users List",
                className: "btn btn-primary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "pdf",
                orientation: "portrait",
                title: "Users List",
                className: "btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "print",
                orientation: "portrait",
                pageSize: "A4",
                title: "Users List",
                className: "btn btn-warning",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
        ],
    };

    var dataTableConfigImrad = {
        paging: true, // Enable pagination
        searching: true, // Enable searching
        ordering: true, // Enable column ordering
        lengthMenu: [10, 20, 50, 70, 100],
        fixedHeader: true,
        responsive: true,
        dom:
            '<"row"<"col-md-6"l><"col-md-6 d-flex justify-content-end"fB>>' +
            '<"row"<"col-md-12"t>>' +
            '<"row"<"col-md-6"i><"col-md-6"p>>',
        buttons: [
            {
                extend: "csv",
                className: "btn btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                },
            },
            {
                extend: "excel",
                title: "Imrad List",
                className: "btn btn-primary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                },
            },
            {
                extend: "pdf",
                orientation: "landscape",
                title: "Imrad List",
                className: "btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                },
            },
            {
                extend: "print",
                orientation: "landscape",
                pageSize: "A4",
                title: "Imrad List",
                className: "btn btn-warning",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                },
            },
        ],
    };

    var dataTableConfigDeletedFile = {
        paging: true, // Enable pagination
        searching: true, // Enable searching
        ordering: true, // Enable column ordering
        lengthMenu: [10, 20, 50, 70, 100],
        fixedHeader: true,
        responsive: true,
        dom:
            '<"row"<"col-md-6"l><"col-md-6 d-flex justify-content-end"fB>>' +
            '<"row"<"col-md-12"t>>' +
            '<"row"<"col-md-6"i><"col-md-6"p>>',
        buttons: [
            {
                extend: "csv",
                className: "btn btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
            {
                extend: "excel",
                title: "Deleted User List",
                className: "btn btn-primary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
            {
                extend: "pdf",
                orientation: "portrait",
                title: "Deleted User List",
                className: "btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
            {
                extend: "print",
                orientation: "portrait",
                pageSize: "A4",
                title: "Deleted User List",
                className: "btn btn-warning",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
        ],
    };

    var dataTableConfigDeletedUser = {
        paging: true, // Enable pagination
        searching: true, // Enable searching
        ordering: true, // Enable column ordering
        lengthMenu: [10, 20, 50, 70, 100],
        fixedHeader: true,
        responsive: true,
        dom:
            '<"row"<"col-md-6"l><"col-md-6 d-flex justify-content-end"fB>>' +
            '<"row"<"col-md-12"t>>' +
            '<"row"<"col-md-6"i><"col-md-6"p>>',
        buttons: [
            {
                extend: "csv",
                className: "btn btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                },
            },
            {
                extend: "excel",
                title: "Deleted User List",
                className: "btn btn-primary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                },
            },
            {
                extend: "pdf",
                orientation: "landscape",
                title: "Deleted User List",
                className: "btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                },
            },
            {
                extend: "print",
                orientation: "landscape",
                pageSize: "A4",
                title: "Deleted User List",
                className: "btn btn-warning",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                },
            },
        ],
    };

    var dataTableConfigView = {
        paging: true, // Enable pagination
        searching: true, // Enable searching
        ordering: true, // Enable column ordering
        lengthMenu: [10, 20, 50, 70, 100],
        fixedHeader: true,
        responsive: true,
        dom:
            '<"row"<"col-md-6"l><"col-md-6 d-flex justify-content-end"f>>' +
            '<"row"<"col-md-12"t>>' +
            '<"row"<"col-md-6"i><"col-md-6"p>>',
    };

    // Initialize DataTables for Users tables
    userTables.forEach(function (table) {
        $(table).DataTable(dataTableConfigUser);
    });

    // Initialize DataTables for File tables
    fileTables.forEach(function (table) {
        $(table).DataTable(dataTableConfigImrad);
    });

    fileDeletedTables.forEach(function (table) {
        $(table).DataTable(dataTableConfigDeletedFile);
    });

    userDeletedTables.forEach(function (table) {
        $(table).DataTable(dataTableConfigDeletedUser);
    });

    viewTables.forEach(function (table) {
        $(table).DataTable(dataTableConfigView);
    });
});
