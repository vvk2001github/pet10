<x-tetris-component>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tetris
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25 flex items-center justify-center gap-6 lg:gap-8 p-6 lg:p-8" >

                    <div class="grid">
                        <canvas id="board" class="game-board"></canvas>
                        <div class="right-column">
                            <div>
                                <h1>TETRIS</h1>
                                <p>Score: <span id="score">0</span></p>
                                <p>Lines: <span id="lines">0</span></p>
                                <p>Level: <span id="level">0</span></p>
                                <canvas id="next" class="next"></canvas>
                            </div>
                            <button onclick="play()" class="play-button">Play</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-tetris-component>
