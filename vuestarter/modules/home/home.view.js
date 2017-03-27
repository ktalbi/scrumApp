var scrum = scrum || {};

scrum.home = function(resolve, reject) {
  resolve({
    template: scrum.templates['home/home']
  })
};
