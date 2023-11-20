import mitt from 'mitt';

const emitter = mitt();

emitter.on('*', (type, e) => console.log(type, e) )

export default emitter;
