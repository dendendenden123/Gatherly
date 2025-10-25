document.addEventListener("DOMContentLoaded", function () {
    let monthEl = document.querySelector("#attendanceTrendChart");
    let monthRaw = monthEl ? JSON.parse(monthEl.dataset.attendance) : null;

    console.log(monthRaw);

    const state = {
        currentTab: "attendance",
        trendRange: "weekly",
        tablePage: 1,
        pageSize: 5,
    };

    const el = {
        attendanceTabBtn: document.getElementById("attendanceTabBtn"),
        engagementTabBtn: document.getElementById("engagementTabBtn"),
        demographicTabBtn: document.getElementById("demographicTabBtn"),
        customTabBtn: document.getElementById("customTabBtn"),
        weeklyBtn: document.getElementById("weeklyBtn"),
        monthlyBtn: document.getElementById("monthlyBtn"),
        yearlyBtn: document.getElementById("yearlyBtn"),
        exportChartBtn: document.getElementById("exportChartBtn"),
        csvBtn: document.getElementById("csvBtn"),
        pdfBtn: document.getElementById("pdfBtn"),
        excelBtn: document.getElementById("excelBtn"),
        dataTableBody: document.getElementById("dataTableBody"),
        pagination: document.getElementById("pagination"),
        fromCount: document.getElementById("fromCount"),
        toCount: document.getElementById("toCount"),
        totalCount: document.getElementById("totalCount"),
        dateRangeSelect: document.getElementById("dateRangeSelect"),
        eventTypeSelect: document.getElementById("eventTypeSelect"),
        ministrySelect: document.getElementById("ministrySelect"),
        generateBtn: document.getElementById("generateBtn"),
        resetBtn: document.getElementById("resetBtn"),
    };

    const mock = {
        charts: {
            attendance: monthRaw,
            engagement: {
                weekly: {
                    x: ["W1", "W2", "W3", "W4"],
                    series: [{ name: "Engagement", data: [70, 75, 78, 80] }],
                },
                monthly: {
                    x: ["Jun", "Jul", "Aug", "Sep", "Oct", "Nov"],
                    series: [
                        {
                            name: "Engagement",
                            data: [68, 70, 72, 74, 78, 80],
                        },
                    ],
                },
                yearly: {
                    x: ["2020", "2021", "2022", "2023", "2024"],
                    series: [
                        { name: "Engagement", data: [60, 65, 70, 75, 78] },
                    ],
                },
                bars: {
                    attendance: ["Groups", "Volunteers", "Donations"],
                    data: [120, 85, 60],
                },
            },
            demographics: {
                weekly: {
                    x: ["Binhi", "Kadiwa", "Buklod"],
                    series: [{ name: "Count", data: [50, 80, 120] }],
                },
                monthly: {
                    x: ["Binhi", "Kadiwa", "Buklod"],
                    series: [{ name: "Count", data: [300, 420, 600] }],
                },
                yearly: {
                    x: ["Binhi", "Kadiwa", "Buklod"],
                    series: [{ name: "Count", data: [3600, 4600, 7200] }],
                },
                bars: {
                    attendance: ["Children", "Youth", "Adults", "Seniors"],
                    data: [90, 150, 320, 60],
                },
            },
            custom: {
                weekly: {
                    x: ["A", "B", "C", "D"],
                    series: [{ name: "Metric", data: [10, 20, 15, 25] }],
                },
                monthly: {
                    x: ["A", "B", "C", "D", "E"],
                    series: [{ name: "Metric", data: [60, 70, 65, 80, 90] }],
                },
                yearly: {
                    x: ["2019", "2020", "2021", "2022", "2023"],
                    series: [
                        { name: "Metric", data: [100, 120, 150, 170, 190] },
                    ],
                },
                bars: { attendance: ["X", "Y", "Z"], data: [12, 9, 20] },
            },
        },
        tables: {
            attendance: Array.from({ length: 47 }).map((_, i) => ({
                name: `Event ${i + 1}`,
                date: "Oct 15, 2023",
                type: [
                    "Sunday Service",
                    "Youth Meeting",
                    "Bible Study",
                    "Prayer Meeting",
                ][i % 4],
                attendance: Math.floor(Math.random() * 400) + 20,
                capacity: [60, 100, 300, 400][i % 4],
                firstTimers: Math.floor(Math.random() * 20),
                engagement: [64, 71.7, 75, 78, 85.5][i % 5],
            })),
            engagement: Array.from({ length: 24 }).map((_, i) => ({
                name: `Member ${i + 1}`,
                date: "Nov 2024",
                type: "Engagement",
                attendance: `${Math.floor(Math.random() * 12)}/14`,
                capacity: "-",
                firstTimers: "-",
                engagement: `${60 + (i % 20)}%`,
            })),
            demographics: Array.from({ length: 30 }).map((_, i) => ({
                name: ["Binhi", "Kadiwa", "Buklod"][i % 3],
                date: "—",
                type: "Group",
                attendance: 20 + (i % 10),
                capacity: "-",
                firstTimers: "-",
                engagement: `${70 + (i % 20)}%`,
            })),
            custom: Array.from({ length: 12 }).map((_, i) => ({
                name: `Custom Report Row ${i + 1}`,
                date: "—",
                type: "Metric",
                attendance: Math.floor(Math.random() * 100),
                capacity: "-",
                firstTimers: "-",
                engagement: `${50 + (i % 40)}%`,
            })),
        },
    };

    let attendanceTrendChart;
    let eventComparisonChart;

    function initCharts() {
        const trendCfg = getTrendConfig();
        attendanceTrendChart = new ApexCharts(
            document.querySelector("#attendanceTrendChart"),
            trendCfg
        );
        attendanceTrendChart.render();

        const barCfg = getBarConfig();
        eventComparisonChart = new ApexCharts(
            document.querySelector("#eventComparisonChart"),
            barCfg
        );
        eventComparisonChart.render();
    }

    function getTrendConfig() {
        const tabCfg = mock.charts[state.currentTab][state.trendRange];
        const colors = ["#4f46e5", "#10b981", "#f59e0b"];
        return {
            series: tabCfg.series,
            chart: {
                height: "100%",
                type: "line",
                zoom: { enabled: false },
                toolbar: { show: false },
            },
            dataLabels: { enabled: false },
            stroke: { curve: "smooth", width: 3 },
            colors,
            xaxis: { categories: tabCfg.x },
            legend: { position: "top" },
            grid: {
                borderColor: "#e7e7e7",
                row: { colors: ["#f8fafc", "transparent"], opacity: 0.5 },
            },
        };
    }

    function getBarConfig() {
        const bar = mock.charts[state.currentTab].bars;
        return {
            series: [{ name: "Value", data: bar.data }],
            chart: {
                type: "bar",
                height: "100%",
                toolbar: { show: false },
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: "55%",
                },
            },
            dataLabels: { enabled: false },
            colors: ["#4f46e5"],
            xaxis: { categories: bar.attendance },
            yaxis: { title: { text: "Value" } },
            grid: {
                borderColor: "#e7e7e7",
                row: { colors: ["#f8fafc", "transparent"], opacity: 0.5 },
            },
        };
    }

    function updateCharts() {
        const trendCfg = mock.charts[state.currentTab][state.trendRange];
        attendanceTrendChart.updateOptions({
            xaxis: { categories: trendCfg.x },
        });
        attendanceTrendChart.updateSeries(trendCfg.series);

        const bar = mock.charts[state.currentTab].bars;
        eventComparisonChart.updateOptions({
            xaxis: { categories: bar.attendance },
            yaxis: { title: { text: "Value" } },
        });
        eventComparisonChart.updateSeries([{ name: "Value", data: bar.data }]);
    }

    function renderTable() {
        const data = mock.tables[state.currentTab];
        const total = data.length;
        const start = (state.tablePage - 1) * state.pageSize;
        const end = Math.min(start + state.pageSize, total);
        const pageRows = data.slice(start, end);

        el.dataTableBody.innerHTML = pageRows
            .map(
                (row) => `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${
                            row.name
                        }</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
                            row.date
                        }</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
                            row.type
                        }</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
                            row.attendance
                        }</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
                            row.capacity
                        }</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
                            row.firstTimers
                        }</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                                Number(
                                    (row.engagement + "").replace("%", "")
                                ) >= 75
                                    ? "bg-green-100 text-green-800"
                                    : "bg-yellow-100 text-yellow-800"
                            }">${row.engagement}${
                    typeof row.engagement === "number" ? "%" : ""
                }</span>
                        </td>
                    </tr>
                `
            )
            .join("");

        el.totalCount.textContent = String(total);
        el.fromCount.textContent = String(total === 0 ? 0 : start + 1);
        el.toCount.textContent = String(end);
        renderPagination(total);
    }

    function renderPagination(total) {
        const pages = Math.max(1, Math.ceil(total / state.pageSize));
        const prevDisabled = state.tablePage === 1;
        const nextDisabled = state.tablePage === pages;
        let html = "";
        html += `<a href="#" data-role="prev" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium ${
            prevDisabled
                ? "text-gray-300 cursor-not-allowed"
                : "text-gray-500 hover:bg-gray-50"
        }"><i class="fas fa-chevron-left"></i></a>`;
        for (let p = 1; p <= pages; p++) {
            const active = p === state.tablePage;
            html += `<a href="#" data-page="${p}" class="${
                active
                    ? "z-10 bg-indigo-50 border-indigo-500 text-indigo-600"
                    : "bg-white border-gray-300 text-gray-500 hover:bg-gray-50"
            } relative inline-flex items-center px-4 py-2 border text-sm font-medium">${p}</a>`;
        }
        html += `<a href="#" data-role="next" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium ${
            nextDisabled
                ? "text-gray-300 cursor-not-allowed"
                : "text-gray-500 hover:bg-gray-50"
        }"><i class="fas fa-chevron-right"></i></a>`;
        el.pagination.innerHTML = html;
    }

    function bindPaginationEvents() {
        el.pagination.addEventListener("click", (e) => {
            e.preventDefault();
            const target = e.target.closest("a");
            if (!target) return;
            const total = mock.tables[state.currentTab].length;
            const pages = Math.max(1, Math.ceil(total / state.pageSize));
            if (target.dataset.page) {
                state.tablePage = Number(target.dataset.page);
            } else if (target.dataset.role === "prev" && state.tablePage > 1) {
                state.tablePage--;
            } else if (
                target.dataset.role === "next" &&
                state.tablePage < pages
            ) {
                state.tablePage++;
            } else {
                return;
            }
            renderTable();
        });
    }

    function setActiveTabButton() {
        const map = {
            attendance: el.attendanceTabBtn,
            engagement: el.engagementTabBtn,
            demographics: el.demographicTabBtn,
            custom: el.customTabBtn,
        };
        [
            el.attendanceTabBtn,
            el.engagementTabBtn,
            el.demographicTabBtn,
            el.customTabBtn,
        ].forEach((b) => {
            b.classList.remove("border-indigo-500", "text-indigo-600");
            b.classList.add("border-transparent", "text-gray-500");
        });
        const active = map[state.currentTab];
        active.classList.remove("border-transparent", "text-gray-500");
        active.classList.add("border-indigo-500", "text-indigo-600");
    }

    function updateTabContent() {
        const tableTitle = document.getElementById("tableTitle");
        const insightsTitle = document.getElementById("insightsTitle");
        const i1t = document.getElementById("insight1Title");
        const i1x = document.getElementById("insight1Text");
        const i2t = document.getElementById("insight2Title");
        const i2x = document.getElementById("insight2Text");
        const i3t = document.getElementById("insight3Title");
        const i3x = document.getElementById("insight3Text");

        const map = {
            attendance: {
                table: "Event Attendance Details",
                insights: "Key Insights",
                i1t: "Top Event by Attendance",
                i1x: "Sunday Morning Service (Oct 15) with 342 attendees",
                i2t: "Highest Engagement",
                i2x: "Johnson Family - attended 12 of 14 events this month",
                i3t: "Growth Opportunity",
                i3x: "Youth events show 15% growth in first-time visitors",
            },
            engagement: {
                table: "Member Engagement Details",
                insights: "Engagement Highlights",
                i1t: "Top Engaged Member",
                i1x: "Jane Doe - 90% participation this month",
                i2t: "Active Groups",
                i2x: "Small Groups participation rose by 12%",
                i3t: "Volunteer Trend",
                i3x: "Volunteering hours up by 8%",
            },
            demographics: {
                table: "Demographic Breakdown",
                insights: "Demographic Insights",
                i1t: "Largest Cohort",
                i1x: "Adults (Buklod) represent 52% of attendees",
                i2t: "Youth Growth",
                i2x: "Kadiwa increased by 10% vs last period",
                i3t: "Children Attendance",
                i3x: "Binhi stable at 18% of total",
            },
            custom: {
                table: "Custom Report Details",
                insights: "Custom Report Insights",
                i1t: "Top Metric",
                i1x: "Metric A shows 25% improvement",
                i2t: "Anomaly Detected",
                i2x: "Metric C dipped by 5% last week",
                i3t: "Forecast",
                i3x: "Expected upward trend next month",
            },
        };

        const cfg = map[state.currentTab];
        tableTitle.textContent = cfg.table;
        insightsTitle.textContent = cfg.insights;
        i1t.textContent = cfg.i1t;
        i1x.textContent = cfg.i1x;
        i2t.textContent = cfg.i2t;
        i2x.textContent = cfg.i2x;
        i3t.textContent = cfg.i3t;
        i3x.textContent = cfg.i3x;
    }

    function setActiveRangeButton() {
        [el.weeklyBtn, el.monthlyBtn, el.yearlyBtn].forEach((b) => {
            b.classList.remove("bg-indigo-100", "text-indigo-700");
            b.classList.add("bg-gray-100", "text-gray-700");
        });
        const map = {
            weekly: el.weeklyBtn,
            monthly: el.monthlyBtn,
            yearly: el.yearlyBtn,
        };
        const active = map[state.trendRange];
        active.classList.remove("bg-gray-100", "text-gray-700");
        active.classList.add("bg-indigo-100", "text-indigo-700");
    }

    function exportCSV(rows) {
        const headers = [
            "Event Name",
            "Date",
            "Type",
            "Attendance",
            "Capacity",
            "First-Timers",
            "Engagement",
        ];
        const data = rows.map((r) => [
            r.name,
            r.date,
            r.type,
            r.attendance,
            r.capacity,
            r.firstTimers,
            r.engagement,
        ]);
        const csv = [headers, ...data].map((r) => r.join(",")).join("\n");
        const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = `${state.currentTab}-report.csv`;
        a.click();
        URL.revokeObjectURL(url);
    }

    function fakeDownload(name, content, type) {
        const blob = new Blob([content], { type });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = name;
        a.click();
        URL.revokeObjectURL(url);
    }

    function bindEvents() {
        document
            .querySelector(".fa-print")
            .closest("button")
            .addEventListener("click", () => window.print());
        const newReportBtn = document
            .querySelector("button i.fa-plus")
            .closest("button");
        let modal = document.getElementById("newReportModal");
        const openModal = () => modal.classList.remove("hidden");
        const closeModal = () => modal.classList.add("hidden");
        newReportBtn.addEventListener("click", openModal);
        document
            .getElementById("closeNewReport")
            .addEventListener("click", closeModal);
        document
            .getElementById("createReport")
            .addEventListener("click", () => {
                closeModal();
                alert("Mock: Report created");
            });

        el.attendanceTabBtn.addEventListener("click", () => {
            state.currentTab = "attendance";
            state.tablePage = 1;
            setActiveTabButton();
            updateCharts();
            renderTable();
            updateTabContent();
        });
        el.engagementTabBtn.addEventListener("click", () => {
            state.currentTab = "engagement";
            state.tablePage = 1;
            setActiveTabButton();
            updateCharts();
            renderTable();
            updateTabContent();
        });
        el.demographicTabBtn.addEventListener("click", () => {
            state.currentTab = "demographics";
            state.tablePage = 1;
            setActiveTabButton();
            updateCharts();
            renderTable();
            updateTabContent();
        });
        el.customTabBtn.addEventListener("click", () => {
            state.currentTab = "custom";
            state.tablePage = 1;
            setActiveTabButton();
            updateCharts();
            renderTable();
            updateTabContent();
        });

        el.weeklyBtn.addEventListener("click", () => {
            state.trendRange = "weekly";
            setActiveRangeButton();
            updateCharts();
        });
        el.monthlyBtn.addEventListener("click", () => {
            state.trendRange = "monthly";
            setActiveRangeButton();
            updateCharts();
        });
        el.yearlyBtn.addEventListener("click", () => {
            state.trendRange = "yearly";
            setActiveRangeButton();
            updateCharts();
        });

        el.generateBtn.addEventListener("click", () => {
            document.querySelector("#filter-form").submit();

            renderTable();
            updateCharts();
        });
        el.resetBtn.addEventListener("click", () => {
            el.dateRangeSelect.selectedIndex = 0;
            el.eventTypeSelect.selectedIndex = 0;
            el.ministrySelect.selectedIndex = 0;
        });

        el.exportChartBtn.addEventListener("click", () => {
            const png = "Mock chart export";
            fakeDownload("chart-export.txt", png, "text/plain");
        });

        el.csvBtn.addEventListener("click", () =>
            exportCSV(mock.tables[state.currentTab])
        );
        el.pdfBtn.addEventListener("click", () =>
            fakeDownload(
                `${state.currentTab}.pdf`,
                "Mock PDF content",
                "application/pdf"
            )
        );
        el.excelBtn.addEventListener("click", () =>
            fakeDownload(
                `${state.currentTab}.xlsx`,
                "Mock Excel content",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            )
        );

        document.getElementById("mobilePrev").addEventListener("click", (e) => {
            e.preventDefault();
            if (state.tablePage > 1) {
                state.tablePage--;
                renderTable();
            }
        });
        document.getElementById("mobileNext").addEventListener("click", (e) => {
            e.preventDefault();
            const total = mock.tables[state.currentTab].length;
            const pages = Math.ceil(total / state.pageSize);
            if (state.tablePage < pages) {
                state.tablePage++;
                renderTable();
            }
        });

        bindPaginationEvents();
    }

    initCharts();
    setActiveTabButton();
    setActiveRangeButton();
    renderTable();
    updateTabContent();
    bindEvents();
});
