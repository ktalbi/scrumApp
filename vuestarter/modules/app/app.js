var ecoreleve = ecoreleve || {};

Vue.use(VueParams);
Vue.use(VueI18Next);

ecoreleve.init = function() {
  //TODO calculate locale, load translations JSON
  //Call ecoreleve.start() when every async things are complete (translations, templates, ...)
  //What about change locale at runtime ?

  Vue.params.i18nextLanguage = "en";
  i18next.init({
    lng: Vue.params.i18nextLanguage,
    resources: {
      en: {
        translation: {
          "hello": "Hello world !",
          "help": "Here is Help page"
        }
      }
    }
  });

  ecoreleve.store = new Vuex.Store({
    modules: {
      user: ecoreleve.storeUser
    }
  });

  var templateNames = ['home/home', 'sprint/sprints', 'sprint/sprint'];
  ecoreleve.templates = {};
  _.forEach(templateNames, function(templateName) {
    axios.get('./modules/' + templateName + '.tpl.html')
      .then(function(response) {
        ecoreleve.templates[templateName] = response.data;
        if (_.keys(ecoreleve.templates).length >= templateNames.length) {
          ecoreleve.start();
        }
      });
  });
};

ecoreleve.start = function() {
  ecoreleve.router = new VueRouter({
    routes: [{
      name: 'home',
      path: '/',
      component: ecoreleve.home
    }, {
      name: 'sprints',
      path: '/sprints',
      component: ecoreleve.sprints
    }, {
      name: 'sprint',
      path: '/sprints/:id',
      props: true,
      component: ecoreleve.sprint
    }]
  });
  ecoreleve.app = new Vue({
    el: '#app',
    router: ecoreleve.router
    /*computed: {
      userProfile: function() {
        return ecoreleve.store.state.user.profile;
      },
      userNames: function() {
        return ecoreleve.store.getters.userNames;
      }
    },
    methods: {
      login: function(e) {
        ecoreleve.store.dispatch('userLogin', {
          firstName: 'Vincent',
          lastName: 'B.',
        });
      }
    }*/
  });
};
