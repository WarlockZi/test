class MorphDTOClass {

  constructor(morphEl) {
    this._morph = {}
    this._morph.relation = morphEl.dataset.morphRelation
    this._morph.oneormany = morphEl.dataset.morphOneormany
    this._morph.slug = morphEl.dataset.morphSlug
    return this
  }

  get morph(){
    return this._morph
  }

  set morph(morph){
    this._morph = morph
  }
}

export default function MorphDTO(morphEl) {
  return new MorphDTOClass(morphEl).morph
}