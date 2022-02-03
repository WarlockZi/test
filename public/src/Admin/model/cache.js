import {$, popup, post} from "../../common";
import "../../components/popup.scss";


let _cache = {
    clearCache: async function () {
        let res = await post('/adminsc/clearCache', {})
        if (res==='Успешно') {
            popup.show(res)
        }
    }
}

export default function cache() {
    $('.clearCache').on('click', _cache.clearCache)
}