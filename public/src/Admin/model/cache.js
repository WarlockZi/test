import {popup, post} from "../../common";
import "../../components/popup.scss";


export let _cache = {
    clearedMsg: 'очищено',
    clearCache: async function () {
        let res = await post('/adminsc/clearCache', {})
        // res = await JSON.parse(res);
        // res = await res.text(res)
        if (res==='Успешно') {
            popup.show(res)
        }
    }
}
