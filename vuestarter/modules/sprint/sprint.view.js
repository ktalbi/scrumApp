var ecoreleve = ecoreleve || {};

ecoreleve.sprints = function(resolve, reject) {
  resolve({
    template: ecoreleve.templates['sprint/sprints'],
    data: function(){
      return {
        sprints: []
      };
    },
    created: function() {
      var self = this;
      axios.get('http://localhost:8082/sprints')
        .then(function(response) {
          self.sprints = response.data;
        });
    }
  })
};

ecoreleve.sprint = function(resolve, reject) {
  resolve({
    template: ecoreleve.templates['sprint/sprint'],
    props: ['id'],
    data: function(){
      return {
        sprint: {}
      };
    },
    created: function() {
      var self = this;
      var id = this.$route.params.id;
      axios.get('http://localhost:8082/sprints/'+id)
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
