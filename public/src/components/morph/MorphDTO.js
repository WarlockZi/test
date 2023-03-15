class MorphDTOClass {

  constructor(target) {
    let morphEl = target.parentNode
    this._morph = {}
    this._morph.relation = morphEl.dataset.morphRelation
    this._morph.oneormany = morphEl.dataset.morphOneormany
    this._morph.slug = morphEl.dataset.morphSlug
    this._morph.path = target.dataset.path??''
    return this
  }

  get morph(){
    return this._morph
  }

  set morph(morph){
    this._morph = morph
  }
}

export default function MorphDTO(target) {
  return new MorphDTOClass(target).morph
}