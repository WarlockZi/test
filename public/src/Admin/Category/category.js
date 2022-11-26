import './category.scss'
import {$} from "../../common";
import Image from '../Image/Image';
import {dnd1} from "../../components/dnd/dnd";
import Morph from "../../components/morph/morph";

let appendTo = $('.image_main .images')[0]
let url = '/adminsc/category/addMainImage'
let tag = `MainImage`
let deltag = `delMainImage`

let props = {appendTo, url, tag, deltag}

let b = new Image(props)
let c = new Morph('MainImage')

dnd1('.add_main_image',
  handleMainImage.bind(null, appendTo, url, tag)
)