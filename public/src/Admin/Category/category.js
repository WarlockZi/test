import './category.scss'
import {$} from "../../common";
import {dnd1} from "../../components/dnd/dnd";

let appendTo = $('.image_main .images')[0]
let url = '/adminsc/product/addMainImage'
let tag = `delMainImage`
dnd1('.add_main_image',
  handleMainImage.bind(null, appendTo, url, tag)
)