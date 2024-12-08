import '../../components/footer/footer.scss'
import {$} from "../../common.js";
import pagination from "../../components/pagination/pagination.js";
import Navigation from "./Navigation/Navigation.js";
import Accordion from "@src/Admin/Test/Accordion/Accordion.js";
// import '../Test/test_results/test_results.js'
// import '../Test/opentest-edit.js'
// import testEdit from '../Test/test-edit.js'
// import '../Test/TestDo.js'
// import '../Test/open_test.js'
import '../../components/cookie/cookie.js'

new pagination
new Navigation
new Accordion

const testDo = $('.test-do').first()
if (testDo) {
   // const {default: TestDo} = await import()
   const {default: TestDo} = await import('./TestDo/TestDo.js')
   new TestDo(testDo)
}
const testEdit = $('.test-edit').first()
if (testEdit) {
   const {default: testEdit} = import('./TestEdit/test-edit.js')
   new testEdit(testEdit)
}
const oTestDo = $('.o-test-do').first()
if (oTestDo) {
   // const{default:oTestDo} = import('./o-TestDo.js')
   new oTestDo(oTestDo)
}

const oTestEdit = $('.o-test-edit').first()
if (oTestEdit) {
   // const{default:oTestEdit} = import('./o-test-edit.js')
   new oTestEdit(oTestEdit)
}