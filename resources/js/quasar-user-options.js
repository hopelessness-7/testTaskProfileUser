// quasar-user-options.js
import { Notify, Dialog, Loading } from 'quasar';

export default {
    config: {
        // Здесь вы можете указать глобальные настройки Quasar
        brand: {
            primary: '#1976D2',
            secondary: '#26A69A',
            accent: '#9C27B0',
            dark: '#1D1D1D',
            positive: '#21BA45',
            negative: '#C10015',
            info: '#31CCEC',
            warning: '#F2C037'
        }
    },
    plugins: {
        Notify, // Подключение плагина уведомлений
        Dialog, // Подключение плагина диалоговых окон
        Loading // Подключение плагина загрузки
    }
};
