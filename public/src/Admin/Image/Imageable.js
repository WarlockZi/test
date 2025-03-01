export default class Imageable {
  tag = '';
  type = 'image';
  urlOne = `/adminsc/image/addMorphOne`
  urlMany = `/adminsc/image/addMorphMany`

  constructor(tag) {
    this.tag = tag
  }
}