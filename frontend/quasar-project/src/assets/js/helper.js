import moment from 'moment'

const helper = {
    stamp2human: function (stamp){
        // return new Date(stamp).toLocaleString('in-ID')
        return moment(stamp).format('YYYY-MM-DD HH:mm')
    },

    wordwraping: function (text, max){
        return text.length > max ? text.substring(1,max)+"..." : text
    }
}

export default helper