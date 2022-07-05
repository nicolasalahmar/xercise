<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\exercise;

class exerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exercise_list = '[
            {
                "name": "3/4 Sit-Up",
                "exercise_id": 1,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "90/90 Hamstring",
                "exercise_id": 2,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Adductor/Groin",
                "exercise_id": 3,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Air Bike",
                "exercise_id": 4,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "All Fours Quad Stretch",
                "exercise_id": 5,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Alternate Heel Touchers",
                "exercise_id": 6,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Alternate Leg Diagonal Bound",
                "exercise_id": 7,
                "Knee": "No",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Ankle Circles",
                "exercise_id": 8,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Ankle On The Knee",
                "exercise_id": 9,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Arm Circles",
                "exercise_id": 10,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Bench Dips",
                "exercise_id": 11,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Bench Jump",
                "exercise_id": 12,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Bent-Knee Hip Raise",
                "exercise_id": 13,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Body-Up",
                "exercise_id": 14,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Bodyweight Squat",
                "exercise_id": 15,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Bodyweight Walking Lunge",
                "exercise_id": 16,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Body Tricep Press",
                "exercise_id": 17,
                "Knee": "No",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Bottoms Up",
                "exercise_id": 18,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Butt-Ups",
                "exercise_id": 19,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Butt Lift (Bridge)",
                "exercise_id": 20,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Calf Stretch Elbows Against Wall",
                "exercise_id": 21,
                "Knee": "No",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Calf Stretch Hands Against Wall",
                "exercise_id": 22,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Carioca Quick Step",
                "exercise_id": 23,
                "Knee": "No",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Cat Stretch",
                "exercise_id": 24,
                "Knee": "No",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Chair Lower Back Stretch",
                "exercise_id": 25,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Child\'s Pose",
                "exercise_id": 26,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Chin-Up",
                "exercise_id": 27,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Chin To Chest Stretch",
                "exercise_id": 28,
                "Knee": "No",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Clock Push-Up",
                "exercise_id": 29,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Close-Grip Push-Up off of a Dumbbell",
                "exercise_id": 30,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Cocoons",
                "exercise_id": 31,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Cross-Body Crunch",
                "exercise_id": 32,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Crossover Reverse Lunge",
                "exercise_id": 33,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Crunches",
                "exercise_id": 34,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Crunch - Hands Overhead",
                "exercise_id": 35,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Crunch - Legs On Exercise Ball",
                "exercise_id": 36,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Dancer\'s Stretch",
                "exercise_id": 37,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Dead Bug",
                "exercise_id": 38,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Decline Crunch",
                "exercise_id": 39,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Decline Oblique Crunch",
                "exercise_id": 40,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Decline Push-Up",
                "exercise_id": 41,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Decline Reverse Crunch",
                "exercise_id": 42,
                "Knee": "No",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Dips - Triceps Version",
                "exercise_id": 43,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Double Leg Butt Kick",
                "exercise_id": 44,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Dynamic Back Stretch",
                "exercise_id": 45,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Dynamic Chest Stretch",
                "exercise_id": 46,
                "Knee": "No",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Elbows Back",
                "exercise_id": 47,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Elbow Circles",
                "exercise_id": 48,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Elbow to Knee",
                "exercise_id": 49,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Fast Skipping",
                "exercise_id": 50,
                "Knee": "No",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Flat Bench Leg Pull-In",
                "exercise_id": 51,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Flat Bench Lying Leg Raise",
                "exercise_id": 52,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Floor Glute-Ham Raise",
                "exercise_id": 53,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Flutter Kicks",
                "exercise_id": 54,
                "Knee": "No",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Freehand Jump Squat",
                "exercise_id": 55,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Frog Hops",
                "exercise_id": 56,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Frog Sit-Ups",
                "exercise_id": 57,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Front Leg Raises",
                "exercise_id": 58,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Glute Kickback",
                "exercise_id": 59,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Gorilla Chin/Crunch",
                "exercise_id": 60,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Groiners",
                "exercise_id": 61,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Groin and Back Stretch",
                "exercise_id": 62,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Hamstring Stretch",
                "exercise_id": 63,
                "Knee": "No",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Handstand Push-Ups",
                "exercise_id": 64,
                "Knee": "No",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Hanging Leg Raise",
                "exercise_id": 65,
                "Knee": "No",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Hanging Pike",
                "exercise_id": 66,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Hip Circles (prone)",
                "exercise_id": 67,
                "Knee": "No",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Hug Knees To Chest",
                "exercise_id": 68,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Hyperextensions With No Hyperextension Bench",
                "exercise_id": 69,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Inchworm",
                "exercise_id": 70,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Incline Push-Up",
                "exercise_id": 71,
                "Knee": "No",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Incline Push-Up Close-Grip",
                "exercise_id": 72,
                "Knee": "No",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Incline Push-Up Medium",
                "exercise_id": 73,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Incline Push-Up Reverse Grip",
                "exercise_id": 74,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Incline Push-Up Wide",
                "exercise_id": 75,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Inverted Row",
                "exercise_id": 76,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Iron Crosses (stretch)",
                "exercise_id": 77,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Isometric Chest Squeezes",
                "exercise_id": 78,
                "Knee": "No",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Isometric Neck Exercise - Front And Back",
                "exercise_id": 79,
                "Knee": "No",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Isometric Neck Exercise - Sides",
                "exercise_id": 80,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Isometric Wipers",
                "exercise_id": 81,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Jackknife Sit-Up",
                "exercise_id": 82,
                "Knee": "No",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Janda Sit-Up",
                "exercise_id": 83,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Kneeling Arm Drill",
                "exercise_id": 84,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Kneeling Forearm Stretch",
                "exercise_id": 85,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Kneeling Hip Flexor",
                "exercise_id": 86,
                "Knee": "No",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Knee Across The Body",
                "exercise_id": 87,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Knee Circles",
                "exercise_id": 88,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Knee Tuck Jump",
                "exercise_id": 89,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Lateral Bound",
                "exercise_id": 90,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Leg-Up Hamstring Stretch",
                "exercise_id": 91,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Leg Lift",
                "exercise_id": 92,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Leg Pull-In",
                "exercise_id": 93,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Linear 3-Part Start Technique",
                "exercise_id": 94,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Linear Acceleration Wall Drill",
                "exercise_id": 95,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Looking At Ceiling",
                "exercise_id": 96,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Lower Back Curl",
                "exercise_id": 97,
                "Knee": "No",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Lying Crossover",
                "exercise_id": 98,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Lying Glute",
                "exercise_id": 99,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Lying Prone Quadriceps",
                "exercise_id": 100,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Middle Back Stretch",
                "exercise_id": 101,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Mountain Climbers",
                "exercise_id": 102,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Moving Claw Series",
                "exercise_id": 103,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Natural Glute Ham Raise",
                "exercise_id": 104,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Oblique Crunches",
                "exercise_id": 105,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Oblique Crunches - On The Floor",
                "exercise_id": 106,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "One Arm Against Wall",
                "exercise_id": 107,
                "Knee": "No",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "One Half Locust",
                "exercise_id": 108,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "One Knee To Chest",
                "exercise_id": 109,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "On Your Side Quad Stretch",
                "exercise_id": 110,
                "Knee": "No",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Overhead Stretch",
                "exercise_id": 111,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Overhead Triceps",
                "exercise_id": 112,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Pelvic Tilt Into Bridge",
                "exercise_id": 113,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Plank",
                "exercise_id": 114,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Plyo Push-up",
                "exercise_id": 115,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Prone Manual Hamstring",
                "exercise_id": 116,
                "Knee": "No",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Pullups",
                "exercise_id": 117,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Push-Ups - Close Triceps Position",
                "exercise_id": 118,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Push-Ups With Feet Elevated",
                "exercise_id": 119,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Push-Up Wide",
                "exercise_id": 120,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Pushups",
                "exercise_id": 121,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Pushups (Close and Wide Hand Positions)",
                "exercise_id": 122,
                "Knee": "No",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Push Up to Side Plank",
                "exercise_id": 123,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Rear Leg Raises",
                "exercise_id": 124,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Reverse Crunch",
                "exercise_id": 125,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Rocket Jump",
                "exercise_id": 126,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Runner\'s Stretch",
                "exercise_id": 127,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Russian Twist",
                "exercise_id": 128,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Scapular Pull-Up",
                "exercise_id": 129,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Scissors Jump",
                "exercise_id": 130,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Scissor Kick",
                "exercise_id": 131,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Seated Biceps",
                "exercise_id": 132,
                "Knee": "No",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Seated Calf Stretch",
                "exercise_id": 133,
                "Knee": "No",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Seated Flat Bench Leg Pull-In",
                "exercise_id": 134,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Seated Floor Hamstring Stretch",
                "exercise_id": 135,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Seated Front Deltoid",
                "exercise_id": 136,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Seated Glute",
                "exercise_id": 137,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Seated Hamstring",
                "exercise_id": 138,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Seated Leg Tucks",
                "exercise_id": 139,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Seated Overhead Stretch",
                "exercise_id": 140,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Shoulder Circles",
                "exercise_id": 141,
                "Knee": "No",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Shoulder Raise",
                "exercise_id": 142,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Shoulder Stretch",
                "exercise_id": 143,
                "Knee": "No",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Side-Lying Floor Stretch",
                "exercise_id": 144,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Side Bridge",
                "exercise_id": 145,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Side Jackknife",
                "exercise_id": 146,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Side Leg Raises",
                "exercise_id": 147,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Side Lying Groin Stretch",
                "exercise_id": 148,
                "Knee": "No",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Side Neck Stretch",
                "exercise_id": 149,
                "Knee": "No",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Side Standing Long Jump",
                "exercise_id": 150,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Side Wrist Pull",
                "exercise_id": 151,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "Single-Arm Push-Up",
                "exercise_id": 152,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Single Leg Butt Kick",
                "exercise_id": 153,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Single Leg Glute Bridge",
                "exercise_id": 154,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Sit-Up",
                "exercise_id": 155,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Sit Squats",
                "exercise_id": 156,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Spider Crawl",
                "exercise_id": 157,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Spinal Stretch",
                "exercise_id": 158,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Split Jump",
                "exercise_id": 159,
                "Knee": "No",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Split Squats",
                "exercise_id": 160,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Standing Gastrocnemius Calf Stretch",
                "exercise_id": 161,
                "Knee": "No",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Standing Hip Circles",
                "exercise_id": 162,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Standing Hip Flexors",
                "exercise_id": 163,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Standing Lateral Stretch",
                "exercise_id": 164,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "Standing Long Jump",
                "exercise_id": 165,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Standing Pelvic Tilt",
                "exercise_id": 166,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Standing Soleus And Achilles Stretch",
                "exercise_id": 167,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Standing Toe Touches",
                "exercise_id": 168,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Standing Towel Triceps Extension",
                "exercise_id": 169,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Star Jump",
                "exercise_id": 170,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Step-up with Knee Raise",
                "exercise_id": 171,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Stomach Vacuum",
                "exercise_id": 172,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Superman",
                "exercise_id": 173,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "The Straddle",
                "exercise_id": 174,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 6
            },
            {
                "name": "Toe Touchers",
                "exercise_id": 175,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Trail Running/Walking",
                "exercise_id": 176,
                "Knee": "No",
                "duration": 2,
                "Kcal": 4
            },
            {
                "name": "Triceps Stretch",
                "exercise_id": 177,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 4
            },
            {
                "name": "Tricep Side Stretch",
                "exercise_id": 178,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Tuck Crunch",
                "exercise_id": 179,
                "Knee": "A little",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Upper Back-Leg Grab",
                "exercise_id": 180,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 7
            },
            {
                "name": "Upper Back Stretch",
                "exercise_id": 181,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Upward Stretch",
                "exercise_id": 182,
                "Knee": "Yes",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "V-Bar Pullup",
                "exercise_id": 183,
                "Knee": "No",
                "duration": 2,
                "Kcal": 6
            },
            {
                "name": "Wide-Grip Rear Pull-Up",
                "exercise_id": 184,
                "Knee": "Yes",
                "duration": 2.5,
                "Kcal": 3
            },
            {
                "name": "Windmills",
                "exercise_id": 185,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 3
            },
            {
                "name": "Wind Sprints",
                "exercise_id": 186,
                "Knee": "No",
                "duration": 2.5,
                "Kcal": 5
            },
            {
                "name": "World\'s Greatest Stretch",
                "exercise_id": 187,
                "Knee": "A little",
                "duration": 2,
                "Kcal": 5
            },
            {
                "name": "Wrist Circles",
                "exercise_id": 188,
                "Knee": "No",
                "duration": 2,
                "Kcal": 7
            },
            {
                "name": "rest",
                "exercise_id": 189,
                "Knee": "No",
                "duration": 0,
                "Kcal": 0
            }
        ]';
        $data = json_decode($exercise_list,true);
        foreach($data as $exercise){
            exercise::factory()->create(['ex_id'=>$exercise['exercise_id'],'name'=>$exercise['name'],'knee'=>$exercise['Knee'],'duration'=>$exercise['duration'],'Kcal'=>$exercise['Kcal']]);
        }


    }

}
