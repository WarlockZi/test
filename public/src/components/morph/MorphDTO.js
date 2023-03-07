class MorphDTO {

  constructor(morphEl,morphedEl) {
    this._morph = {}
    this._morph.model = morphEl.dataset.model
    this._morph.id = morphEl.dataset.id

    this._morphed = {}
    this._morphed.relation = morphedEl.dataset.relation
    this._morphed.oneormany = morphedEl.dataset.oneormany
    this._morphed.slug = morphedEl.dataset.slug

    return this
  }

  set morph(morph) {
    this._morph = morph
  }

  get morph() {
    return this.morph
  }


}

export default function MorphDTO(morphEl,morphedEl) {
  new MorphDTO(morphEl,morphedEl)
}