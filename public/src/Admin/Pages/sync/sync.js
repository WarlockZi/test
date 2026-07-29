import "./sync1c.scss";
import { SyncClass } from "./SyncClass.js";
import { $ } from "@src/common.js";

let $sync = $(".sync").first();
if ($sync) {
  new SyncClass($sync);
}
