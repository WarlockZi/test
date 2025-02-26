class MorphDTOClass {

  constructor($table) {
    let $morph = $table.parentNode;
    this._morph = {};
    this._morph.relation = $morph.dataset.morphRelation;
    this._morph.oneormany = $morph.dataset.morphOneormany;
    this._morph.slug = $morph.dataset.morphSlug;
    this._morph.path = $table.dataset.path??''
    // return this
  }

  get morph(){
    return this._morph
  }

  set morph(morph){
    this._morph = morph
  }
}

export default function MorphDTO($table) {
  return new MorphDTOClass($table).morph
}