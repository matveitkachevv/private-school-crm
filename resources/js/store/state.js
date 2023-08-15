export default {
    events: [],
    groups: [],
    students: [],
    cabinets: [],
    notes: [],
    newEvent: {
        name: '',
        class: 'lesson',
        cabinet_id: 0,
        group_id: 0,
        repeat: []
    },
    theme: 'dark',
    links: [
        ['mdi-calendar-blank', 'Расписание', '/'],
        ['mdi-account-group', 'Группы', '/groups/'],
        ['mdi-account', 'Ученики', '/users/'],
        ['mdi-door', 'Кабинеты', '/cabinets/'],
        ['mdi-note-outline', 'Заметки', '/notes/'],
    ],
    modal: {
        show: false,
        message: 'Ошибка'
    }
}
