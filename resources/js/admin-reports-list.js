$(document).ready(function () {
    let listAjax = null;

    function setListContent(html) {
        $("#attendanceListContainer").html(html);
    }

    function showTemplate(templateId) {
        const tpl = document.getElementById(templateId);
        if (tpl) setListContent(tpl.innerHTML);
    }

    function buildPrintUrl() {
        const params = $("#filterForm").serialize();
        return (
            $("<a>")
                .attr("href", $("#exportAttendanceBtn").data("base"))
                .attr("href") +
            "?" +
            params
        );
    }

    function refreshExportLink() {
        const params = $("#filterForm").serialize();
        const base = $("#exportAttendanceBtn").data("base");
        $("#exportAttendanceBtn").attr("href", base + "?" + params);
    }

    function loadList() {
        if (listAjax) listAjax.abort();
        showTemplate("attendanceListLoadingTemplate");
        listAjax = $.get(
            $("#attendanceListContainer").data("url"),
            $("#filterForm").serialize()
        )
            .done(function (res) {
                if (res && res.html && res.html.trim().length > 0) {
                    setListContent(res.html);
                } else {
                    showTemplate("attendanceListEmptyTemplate");
                }
            })
            .fail(function () {
                showTemplate("attendanceListErrorTemplate");
            });
        refreshExportLink();
    }

    // Attach base URL for export
    const exportBase = $("#exportAttendanceBtn").data("base");
    if (!exportBase) {
        $("#exportAttendanceBtn").attr(
            "data-base",
            $("#exportAttendanceBtn").attr("href") ||
                $("#exportAttendanceBtn").data("base")
        );
    }

    // Wire filter actions
    $("#applyFiltersBtn").on("click", function (e) {
        e.preventDefault();
        loadList();
    });

    $("#filterForm").on("change input", function () {
        refreshExportLink();
    });

    // Initialize container attrs
    $("#attendanceListContainer").attr(
        "data-url",
        $("#attendanceListContainer").data("url") ||
            $("#attendanceListContainer").attr("data-url")
    );

    // Initial export link setup
    refreshExportLink();
});
