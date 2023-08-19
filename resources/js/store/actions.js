export default {
    getEvents (context) {
        context.commit('getEvents')
    },
    getGroups (context) {
        context.commit('getGroups')
    },
    getStudents (context) {
        context.commit('getStudents')
    },
    getCabinets (context) {
        context.commit('getCabinets')
    },
    clearRepeats (context) {
        context.commit('clearRepeats')
    },
    clearNewEvent (context) {
        context.commit('clearNewEvent')
    },
    createEvent (context) {
        axios({
            method: 'post',
            url: '/event/',
            data: {
                name: context.state.newEvent.name,
                class: context.state.newEvent.class,
                cabinet_id: context.state.newEvent.cabinet_id,
                group_id: context.state.newEvent.group_id,
                repeats: context.state.newEvent.repeat,
            }
        }).catch(error => {
            if(error.response.data.error){
                context.commit('modalMessage', error.response.data.message);
                context.commit('modalShow', true);
            }
        });
    },
    getNotes (context) {
        axios({
            method: 'get',
            url: '/notes/'
        }).then(response => {
            if(response.status === 200){
                context.commit('setNotes', response.data)
            }
        });
    },
}
