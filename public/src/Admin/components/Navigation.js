import { $ } from "../../common.js";

export default class Navigation {
  static ROUTES = [
    {
      pattern: /\/adminsc\/(settings|right\/list|post\/list|todo\/list)/,
      menuId: "settings",
    },
    { pattern: /\/auth\/profile/, menuId: "profile" },
    { pattern: /\/adminsc\/crm/, menuId: "crm" },
    { pattern: /\/adminsc\/planning/, menuId: "planning" },
    { pattern: /\/adminsc\/(category|product)/, menuId: "catalog" },
    {
      pattern: /(\/test|\/opentest|\/adminsc\/(opentest|test))/,
      menuId: "test",
    },
  ];
  constructor() {
    this.old();
    // this.highlightCurrentPage();
  }
  old() {
    const str = window.location.pathname;
    if (
      /\/adminsc\/settings/.test(str) ||
      /\/adminsc\/right\/list/.test(str) ||
      /\/adminsc\/post\/list/.test(str) ||
      /\/adminsc\/todo\/list/.test(str)
    ) {
      // rights()
      $("[settings]").addClass("current");
    } else if (/\/auth\/profile/.test(str)) {
      // user()
    } else if (/\/adminsc\/crm/.test(str)) {
      $("[crm]").addClass("current");
    } else if (/\/adminsc\/planning/.test(str)) {
      $("[plan]").addClass("current");
    } else if (
      /\/adminsc\/category/.test(str) ||
      /\/adminsc\/product/.test(str)
    ) {
      $("[catalog]").addClass("current");
    } else if (
      /\/test/.test(str) ||
      /\/opentest/.test(str) ||
      /\/adminsc\/opentest/.test(str) ||
      /\/adminsc\/test/.test(str)
    ) {
      $("[test]").addClass("current");
    } else {
      $("[href='/adminsc']").addClass("current");
    }
  }
  highlightCurrentPage() {
    const pathname = window.location.pathname;
    const activeRoute = Navigation.ROUTES.find((route) =>
      route.pattern.test(pathname),
    );
    const activeMenuId = activeRoute ? activeRoute.menuId : "dashboard";
    $(`[data-menu-id="${activeMenuId}"]`).addClass("current");
  }
}
