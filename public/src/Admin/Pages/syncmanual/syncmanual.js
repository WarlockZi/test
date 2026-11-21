import "./sync_manual.scss";
import SyncManualApp from "@src/Admin/Pages/syncmanual/components/SyncManualApp.js";

export default class syncmanual {
  constructor() {
    const app = new SyncManualApp(".sync-manual");

    return () => app.destroy();
  }
}
