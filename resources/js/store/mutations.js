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
    createEvent (state) {
        axios({
            method: 'post',
            url: '/event/',
            data: {
                name: state.newEvent.name,
                class: state.newEvent.class,
                cabinet_id: state.newEvent.cabinet_id,
                group_id: state.newEvent.group_id,
                repeats: state.newEvent.repeat,
           }
        });
    },
}
