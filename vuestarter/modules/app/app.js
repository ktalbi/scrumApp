var scrum = scrum || {};

Vue.use(VueParams);
Vue.use(VueI18Next);




scrum.init = function() {
  //TODO calculate locale, load translations JSON
  //Call scrum.start() when every async things are complete (translations, templates, ...)
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

  scrum.store = new Vuex.Store({
    modules: {
      user: scrum.storeUser
    }
  });

  var templateNames = ['home/home', 'sprint/sprints', 'sprint/sprint', 'hours/hours', 'charts/charts'];
  scrum.templates = {};
  _.forEach(templateNames, function(templateName) {
    axios.get('./modules/' + templateName + '.tpl.html')
      .then(function(response) {
        scrum.templates[templateName] = response.data;
        if (_.keys(scrum.templates).length >= templateNames.length) {
          scrum.start();
        }
      });
  });
};

scrum.start = function() {
  scrum.router = new VueRouter({
    routes: [{
      name: 'home',
      path: '/',
      component: scrum.home
    }, {
      name: 'sprints',
      path: '/sprints',
      component: scrum.sprints
    }, {
      name: 'sprint',
      path: '/sprints/:id',
      props: true,
      component: scrum.sprint
    }, {
      name: 'hours',
      path: '/hours',
      component: scrum.hours
    }, {
      name: 'charts',
      path: '/charts',
      component: scrum.charts
    }]
  });
  scrum.app = new Vue({
    el: '#app',
    router: scrum.router
    /*computed: {
      userProfile: function() {
        return scrum.store.state.user.profile;
      },
      userNames: function() {
        return scrum.store.getters.userNames;
      }
    },
    methods: {
      login: function(e) {
        scrum.store.dispatch('userLogin', {
          firstName: 'Vincent',
          lastName: 'B.',
        });
      }
    }*/
  });
};
