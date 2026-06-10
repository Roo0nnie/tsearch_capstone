const selectors = {
    dropdownToggle: '[data-ui-toggle="dropdown"]',
    dropdownMenu: "[data-ui-menu], .dropdown-menu",
    collapseToggle: '[data-ui-toggle="collapse"]',
    modalToggle: '[data-ui-toggle="modal"]',
    modalDismiss: '[data-ui-dismiss="modal"]',
    tabToggle: '[data-ui-toggle="tab"]',
};

function targetFrom(trigger) {
    const selector = trigger?.dataset?.uiTarget || trigger?.getAttribute("href");

    if (!selector || selector === "#") {
        return null;
    }

    try {
        return document.querySelector(selector);
    } catch {
        return null;
    }
}

function setExpanded(trigger, expanded) {
    if (trigger) {
        trigger.setAttribute("aria-expanded", expanded ? "true" : "false");
    }
}

function closeAllDropdowns(except = null) {
    document.querySelectorAll(".dropdown-menu.show, [data-ui-menu].show").forEach((menu) => {
        if (menu === except) {
            return;
        }

        menu.classList.remove("show");
        const owner = menu.closest("[data-ui-dropdown], .dropdown");
        owner?.querySelector(selectors.dropdownToggle)?.setAttribute("aria-expanded", "false");
    });
}

function toggleDropdown(trigger) {
    const owner = trigger.closest("[data-ui-dropdown], .dropdown") || trigger.parentElement;
    const menu = owner?.querySelector(selectors.dropdownMenu);

    if (!menu) {
        return;
    }

    const shouldOpen = !menu.classList.contains("show");
    closeAllDropdowns(menu);
    menu.classList.toggle("show", shouldOpen);
    setExpanded(trigger, shouldOpen);
}

function toggleCollapse(trigger) {
    const panel = targetFrom(trigger);

    if (!panel) {
        return;
    }

    const parentSelector = trigger.dataset.uiParent;
    const shouldOpen = !panel.classList.contains("show");

    if (parentSelector && shouldOpen) {
        document.querySelectorAll(`${parentSelector} .collapse.show`).forEach((openPanel) => {
            if (openPanel !== panel) {
                openPanel.classList.remove("show");
            }
        });
    }

    panel.classList.toggle("show", shouldOpen);
    setExpanded(trigger, shouldOpen);
}

function openModal(modal) {
    if (!modal) {
        return;
    }

    modal.classList.add("show");
    modal.removeAttribute("aria-hidden");
    document.body.classList.add("overflow-hidden");
    const focusTarget = modal.querySelector("[autofocus], button, [href], input, select, textarea");
    focusTarget?.focus?.();
}

function closeModal(modal) {
    if (!modal) {
        return;
    }

    modal.classList.remove("show");
    modal.setAttribute("aria-hidden", "true");

    if (!document.querySelector(".modal.show")) {
        document.body.classList.remove("overflow-hidden");
    }
}

function activateTab(trigger) {
    const panel = targetFrom(trigger);

    if (!panel) {
        return;
    }

    const triggerGroup = trigger.closest(".nav-tabs, .nav-pills, .nav");
    triggerGroup?.querySelectorAll(selectors.tabToggle).forEach((item) => {
        item.classList.remove("active");
        item.setAttribute("aria-selected", "false");
    });

    const panelGroup = panel.closest(".tab-content");
    panelGroup?.querySelectorAll(".tab-pane").forEach((item) => {
        item.classList.remove("active", "show");
    });

    trigger.classList.add("active");
    trigger.setAttribute("aria-selected", "true");
    panel.classList.add("active", "show");

    trigger.dispatchEvent(
        new CustomEvent("shown.ui.tab", {
            bubbles: true,
            detail: { target: panel },
        }),
    );

    return {
        show: () => activateTab(trigger),
    };
}

function openActiveSidebarGroups() {
    document.querySelectorAll(".sidebar .nav-item.active .collapse").forEach((panel) => {
        panel.classList.add("show");
        const trigger = panel.parentElement?.querySelector(selectors.collapseToggle);
        setExpanded(trigger, true);
    });
}

function bindShellToggles() {
    document.querySelectorAll(".toggle-sidebar, .sidenav-toggler").forEach((trigger) => {
        trigger.addEventListener("click", (event) => {
            event.preventDefault();
            trigger.closest(".wrapper")?.classList.toggle("sidebar_minimize");
        });
    });

    document.querySelectorAll(".nav_toggle, .topbar-toggler").forEach((trigger) => {
        trigger.addEventListener("click", (event) => {
            event.preventDefault();
            document.documentElement.classList.toggle("nav_open");
        });
    });
}

document.addEventListener("click", (event) => {
    const dropdownToggle = event.target.closest(selectors.dropdownToggle);
    if (dropdownToggle) {
        event.preventDefault();
        toggleDropdown(dropdownToggle);
        return;
    }

    const collapseToggle = event.target.closest(selectors.collapseToggle);
    if (collapseToggle) {
        event.preventDefault();
        toggleCollapse(collapseToggle);
        return;
    }

    const modalToggle = event.target.closest(selectors.modalToggle);
    if (modalToggle) {
        event.preventDefault();
        openModal(targetFrom(modalToggle));
        return;
    }

    const modalDismiss = event.target.closest(selectors.modalDismiss);
    if (modalDismiss) {
        event.preventDefault();
        closeModal(modalDismiss.closest(".modal"));
        return;
    }

    const tabToggle = event.target.closest(selectors.tabToggle);
    if (tabToggle) {
        event.preventDefault();
        activateTab(tabToggle);
        return;
    }

    if (event.target.classList.contains("modal")) {
        closeModal(event.target);
        return;
    }

    if (!event.target.closest("[data-ui-dropdown], .dropdown")) {
        closeAllDropdowns();
    }
});

document.addEventListener("keydown", (event) => {
    if (event.key !== "Escape") {
        return;
    }

    closeAllDropdowns();
    closeModal(document.querySelector(".modal.show"));
});

document.addEventListener("DOMContentLoaded", () => {
    openActiveSidebarGroups();
    bindShellToggles();

    document.querySelectorAll(`${selectors.tabToggle}.active`).forEach((trigger) => {
        activateTab(trigger);
    });
});

window.TSearchUI = {
    activateTab,
    closeAllDropdowns,
    closeModal,
    openModal,
    toggleCollapse,
    toggleDropdown,
};
