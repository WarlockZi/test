import Search_class from "@src/Modules/share/search/search_class.js";

export default class Search_opener {
  constructor(HTMLElement) {
    new Search_class(false, HTMLElement);
  }
}
