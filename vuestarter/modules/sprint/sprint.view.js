

var scrum = scrum || {};


scrum.sprints = function(resolve, reject) {
  resolve({
    template: scrum.templates['sprint/sprints'],
    data: function(){
      return {
        sprints: []
      };
    },
    created: function() {
      var self = this;
      axios.get('http://localhost:8080/sprints')
        .then(function(response) {
          self.sprints = response.data;
        });
    }
  })
};




scrum.sprint = function(resolve, reject) {
  resolve({
    template: scrum.templates['sprint/sprint'],
    props: ['id'],
    data: function(){
      return {
        sprint: {}
      };
    },
    created: function() {
      var self = this;
      var id = this.$route.params.id;
      axios.get('http://localhost:8080/sprints/'+id)
        .then(function(response) {
          self.sprint = response.data;
        });
    },
    methods: {
      onSubmit: function(e) {
        console.log('ok', e);
      }
    }
  })
};
