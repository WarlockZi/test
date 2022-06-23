import {$, popup, post} from "../../common";
import "../../components/popup.scss";


let _cache = {
    clearCache: async function () {
        let res = await post('/adminsc/clearCache', {})
    }
}

export default function cache() {
    $('.clearCache').on('click', _cache.clearCache)
}