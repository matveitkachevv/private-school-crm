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
        context.commit('createEvent')
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
