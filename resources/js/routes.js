import Schedule from "./components/Schedule.vue";
import Groups from "./components/Groups.vue";
import Users from "./components/Users.vue";
import EventDetail from "./components/detail/EventDetail.vue";
import GroupDetail from "./components/detail/GroupDetail.vue";
import UserDetail from "./components/detail/UserDetail.vue";
import Cabinets from "./components/Cabinets.vue";


export default [
    {
        path: '/',
        name: 'Schedule',
        component: Schedule
    },
    {
        path: '/groups/',
        name: 'Groups',
        component: Groups
    },
    {
        path: '/cabinets/',
        name: 'Cabinets',
        component: Cabinets
    },
    {
        path: '/users/',
        name: 'Users',
        component: Users
    },
    {
        path: '/event/:id/detail/',
        name: 'EventDetail',
        component: EventDetail
    },
    {
        path: '/group/:id/',
        name: 'GroupDetail',
        component: GroupDetail
    },
    {
        path: '/user/:id/',
        name: 'UserDetail',
        component: UserDetail
    },
]
