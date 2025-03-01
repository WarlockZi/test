export default class pagination {
  constructor(){
    let pagination = $('.pagination').first();
    if (!pagination) return false;
    this.pagination = pagination;
    this.model = pagination.dataset.model
  }

}