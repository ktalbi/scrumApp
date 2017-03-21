var ecoreleve = ecoreleve || {};

ecoreleve.storeUser = {
  state: {
    profile: {}
  },
  getters: {
    userNames: function(state) {
      if (_.isEmpty(state.profile))
        return '';
      return state.profile.firstName + ' ' + state.profile.lastName;
    }
  },
  mutations: {
    userSetProfile: function(state, profile) {
      state.profile = profile;
    }
  },
  actions: {
    userLogin: function(context, options) {
      setTimeout(function() {
        context.commit('userSetProfile', {
          firstName: options.firstName,
          lastName: options.lastName
        });
      }, 100);
    }
  }
};
