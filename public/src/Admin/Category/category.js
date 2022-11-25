import './category.scss'
import {$} from "../../common";
import Image from '../Image/Image';
import {dnd1} from "../../components/dnd/dnd";

let appendTo = $('.image_main .images')[0]
let url = '/adminsc/product/addMainImage'
let tag = `MainImage`
let deltag = `delMainImage`

let c = new Image('MainImage')

dnd1('.add_main_image',
  handleMainImage.bind(null, appendTo, url, tag)
)
