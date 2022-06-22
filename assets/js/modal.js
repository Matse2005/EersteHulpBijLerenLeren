function openModal(modelID) {
  this.trapCleanup = focusTrap(document.querySelector(modelID));
}

function closeModal(modelID) {
  this.trapCleanup(modelID);
}
