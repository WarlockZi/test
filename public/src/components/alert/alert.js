import './alert.scss'
import {$} from '../../common'


$("body").on("click", function (e) {
        if (e.target.className === "messageClose") {
            // alert(e.target.className)
        }
    }
);