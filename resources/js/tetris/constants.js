export const COLS = 10;
export const ROWS = 20;
export const BLOCK_SIZE = 30;
export const KEY = {
    LEFT: 37,
    RIGHT: 39,
    DOWN: 40,
    SPACE: 32,
    UP: 38,
}
Object.freeze(KEY);

export const COLORS = [
    'cyan',
    'blue',
    'orange',
    'yellow',
    'green',
    'purple',
    'red'
];
Object.freeze(COLORS);

export const SHAPES = [
    [[0, 0, 0, 0],
     [1, 1, 1, 1],
     [0, 0, 0, 0],
     [0, 0, 0, 0]],

    [[2, 0, 0],
     [2, 2, 2],
     [0, 0, 0]],

    [[0, 0, 3],
     [3, 3, 3],
     [0, 0, 0]],

    [[4, 4],
     [4, 4]],

    [[0, 5, 5],
     [5, 5, 0],
     [0, 0, 0]],

    [[0, 6, 0],
     [6, 6, 6],
     [0, 0, 0]],

    [[7, 7, 0],
     [0, 7, 7],
     [0, 0, 0]]
  ];
  Object.freeze(SHAPES);
