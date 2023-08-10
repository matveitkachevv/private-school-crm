import Schedule from "./components/Schedule.vue";
import Groups from "./components/Groups.vue";
import Users from "./components/Users.vue";
import EventDetail from "./components/detail/EventDetail.vue";
import GroupDetail from "./components/detail/GroupDetail.vue";
import UserDetail from "./components/detail/UserDetail.vue";
import Cabinets from "./components/Cabinets.vue";
import Notes from './components/Notes.vue'
import NoteDetail from "./components/detail/NoteDetail.vue";
import Login from './components/auth/Login.vue';


export default [
    {
        path: '/',
        name: 'Schedule',
        component: Schedule
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/event/:id/detail/',
        name: 'EventDetail',
        component: EventDetail
    },
    {
        path: '/groups/',
        name: 'Groups',
        component: Groups
    },
    {
        path: '/group/:id/',
        name: 'GroupDetail',
        component: GroupDetail
    },
    {
        path: '/cabinets/',
        name: 'Cabinets',
        component: Cabinets
    },
    {
        path: '/notes/',
        name: 'Notes',
        component: Notes
    },
    {
        path: '/note/:id/',
        name: 'NoteDetail',
        component: NoteDetail
    },
    {
        path: '/users/',
        name: 'Users',
        component: Users
    },
    {
        path: '/user/:id/',
        name: 'UserDetail',
        component: UserDetail
    },
]
