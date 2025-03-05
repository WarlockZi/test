import {$, post} from "../../common";

let _cache = {
    clearCache: async function () {
        let res = await post('/adminsc/clearCache', {})
    }
};

export default function cache() {
    $('.clearCache').on('click', _cache.clearCache)
}