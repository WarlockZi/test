import {$} from "../../common";
import Pagination from "../../Admin/Test/test-pagination/Pagination.js";

export default function () {
  return new Pagination({
    'pClass': '[data-pagination]',
    'pActiveClass': 'active',
    'pageClass': 'question',
    'pageActiveClass': 'show',
    'prevBttnId': '#prev',
    'nextBttnId': '#next',
  })
}
