export default {
    getEvents (state) {
        axios({
            method: 'get',
            url: '/events/',
        }).then(events => {
            state.events = events.data;
        });
    },
    getGroups (state) {
        axios({
            method: 'get',
            url: '/groups/',
        }).then(groups => {
            state.groups = groups.data;
        });
    },
    getStudents (state){
        axios({
            method: 'get',
            url: '/users/',
        }).then(users => {
            state.students = users.data;
        });
    },
    getCabinets (state){
        axios({
            method: 'get',
            url: '/cabinets/',
        }).then(cabinets => {
            state.cabinets = cabinets.data;
        });
    },
    addToNewEvent (state, data) {
        state.newEvent[data.key] = data.value;
    },
    addToNewEventDateRepeat (state, data) {
        state.newEvent.repeat.push(data);
    },
    clearRepeats (state) {
        state.newEvent.repeat = [];
    },
    clearNewEvent (state) {
        state.newEvent = {};
    },
    setNotes (state, notes) {
        state.notes = notes;
    },
    modalShow (state, show) {
        state.modal.show = show;
    },
    modalMessage (state, message) {
        state.modal.message = message;
    },
}
