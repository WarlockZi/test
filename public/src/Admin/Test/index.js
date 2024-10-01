import {$} from "../../common.js";
import pagination from "../../components/pagination/pagination.js";
// import '../Test/test_results/test_results.js'
// import '../Test/opentest-edit.js'
// import testEdit from '../Test/test-edit.js'
// import '../Test/test-do.js'
// import '../Test/open_test.js'

new pagination

const testDo = $('.test-do').first()
if (testDo){
   const{default:TestDo} = import('./test-do.js')
   new TestDo(testDo)
}
const testEdit = $('.test-edit').first()
if (testEdit){
   const{default:testEdit} = import('./test-edit.js')
   new testEdit(testEdit)
}
const oTestDo = $('.o-test-do').first()
if (oTestDo){
   // const{default:oTestDo} = import('./o-test-do.js')
   new oTestDo(oTestDo)
}

const oTestEdit = $('.o-test-edit').first()
if (oTestEdit){
   // const{default:oTestEdit} = import('./o-test-edit.js')
   new oTestEdit(oTestEdit)
}