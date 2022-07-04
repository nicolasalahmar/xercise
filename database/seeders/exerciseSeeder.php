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
            { "name": "3/4 Sit-Up", "exercise_id": 1, "Knee": "A little" },
            { "name": "90/90 Hamstring", "exercise_id": 2, "Knee": "No" },
            { "name": "Adductor/Groin", "exercise_id": 3, "Knee": "No" },
            { "name": "Air Bike", "exercise_id": 4, "Knee": "No" },
            { "name": "All Fours Quad Stretch", "exercise_id": 5, "Knee": "Yes" },
            { "name": "Alternate Heel Touchers", "exercise_id": 6, "Knee": "No" },
            { "name": "Alternate Leg Diagonal Bound", "exercise_id": 7, "Knee": "No" },
            { "name": "Ankle Circles", "exercise_id": 8, "Knee": "Yes" },
            { "name": "Ankle On The Knee", "exercise_id": 9, "Knee": "A little" },
            { "name": "Arm Circles", "exercise_id": 10, "Knee": "Yes" },
            { "name": "Bench Dips", "exercise_id": 11, "Knee": "No" },
            { "name": "Bench Jump", "exercise_id": 12, "Knee": "A little" },
            { "name": "Bent-Knee Hip Raise", "exercise_id": 13, "Knee": "No" },
            { "name": "Body-Up", "exercise_id": 14, "Knee": "Yes" },
            { "name": "Bodyweight Squat", "exercise_id": 15, "Knee": "Yes" },
            { "name": "Bodyweight Walking Lunge", "exercise_id": 16, "Knee": "No" },
            { "name": "Body Tricep Press", "exercise_id": 17, "Knee": "No" },
            { "name": "Bottoms Up", "exercise_id": 18, "Knee": "A little" },
            { "name": "Butt-Ups", "exercise_id": 19, "Knee": "A little" },
            { "name": "Butt Lift (Bridge)", "exercise_id": 20, "Knee": "Yes" },
            {
              "name": "Calf Stretch Elbows Against Wall",
              "exercise_id": 21,
              "Knee": "No"
            },
            {
              "name": "Calf Stretch Hands Against Wall",
              "exercise_id": 22,
              "Knee": "A little"
            },
            { "name": "Carioca Quick Step", "exercise_id": 23, "Knee": "Yes" },
            { "name": "Cat Stretch", "exercise_id": 24, "Knee": "A little" },
            { "name": "Chair Lower Back Stretch", "exercise_id": 25, "Knee": "A little" },
            { "name": "Child\'s Pose", "exercise_id": 26, "Knee": "No" },
            { "name": "Chin-Up", "exercise_id": 27, "Knee": "A little" },
            { "name": "Chin To Chest Stretch", "exercise_id": 28, "Knee": "Yes" },
            { "name": "Clock Push-Up", "exercise_id": 29, "Knee": "A little" },
            {
              "name": "Close-Grip Push-Up off of a Dumbbell",
              "exercise_id": 30,
              "Knee": "A little"
            },
            { "name": "Cocoons", "exercise_id": 31, "Knee": "Yes" },
            { "name": "Cross-Body Crunch", "exercise_id": 32, "Knee": "A little" },
            { "name": "Crossover Reverse Lunge", "exercise_id": 33, "Knee": "Yes" },
            { "name": "Crunches", "exercise_id": 34, "Knee": "A little" },
            { "name": "Crunch - Hands Overhead", "exercise_id": 35, "Knee": "A little" },
            { "name": "Crunch - Legs On Exercise Ball", "exercise_id": 36, "Knee": "No" },
            { "name": "Dancer\'s Stretch", "exercise_id": 37, "Knee": "A little" },
            { "name": "Dead Bug", "exercise_id": 38, "Knee": "A little" },
            { "name": "Decline Crunch", "exercise_id": 39, "Knee": "Yes" },
            { "name": "Decline Oblique Crunch", "exercise_id": 40, "Knee": "A little" },
            { "name": "Decline Push-Up", "exercise_id": 41, "Knee": "No" },
            { "name": "Decline Reverse Crunch", "exercise_id": 42, "Knee": "A little" },
            { "name": "Dips - Triceps Version", "exercise_id": 43, "Knee": "A little" },
            { "name": "Double Leg Butt Kick", "exercise_id": 44, "Knee": "A little" },
            { "name": "Dynamic Back Stretch", "exercise_id": 45, "Knee": "A little" },
            { "name": "Dynamic Chest Stretch", "exercise_id": 46, "Knee": "A little" },
            { "name": "Elbows Back", "exercise_id": 47, "Knee": "No" },
            { "name": "Elbow Circles", "exercise_id": 48, "Knee": "A little" },
            { "name": "Elbow to Knee", "exercise_id": 49, "Knee": "A little" },
            { "name": "Fast Skipping", "exercise_id": 50, "Knee": "No" },
            { "name": "Flat Bench Leg Pull-In", "exercise_id": 51, "Knee": "A little" },
            { "name": "Flat Bench Lying Leg Raise", "exercise_id": 52, "Knee": "No" },
            { "name": "Floor Glute-Ham Raise", "exercise_id": 53, "Knee": "A little" },
            { "name": "Flutter Kicks", "exercise_id": 54, "Knee": "No" },
            { "name": "Freehand Jump Squat", "exercise_id": 55, "Knee": "A little" },
            { "name": "Frog Hops", "exercise_id": 56, "Knee": "A little" },
            { "name": "Frog Sit-Ups", "exercise_id": 57, "Knee": "A little" },
            { "name": "Front Leg Raises", "exercise_id": 58, "Knee": "Yes" },
            { "name": "Glute Kickback", "exercise_id": 59, "Knee": "A little" },
            { "name": "Gorilla Chin/Crunch", "exercise_id": 60, "Knee": "No" },
            { "name": "Groiners", "exercise_id": 61, "Knee": "Yes" },
            { "name": "Groin and Back Stretch", "exercise_id": 62, "Knee": "Yes" },
            { "name": "Hamstring Stretch", "exercise_id": 63, "Knee": "Yes" },
            { "name": "Handstand Push-Ups", "exercise_id": 64, "Knee": "Yes" },
            { "name": "Hanging Leg Raise", "exercise_id": 65, "Knee": "No" },
            { "name": "Hanging Pike", "exercise_id": 66, "Knee": "Yes" },
            { "name": "Hip Circles (prone)", "exercise_id": 67, "Knee": "A little" },
            { "name": "Hug Knees To Chest", "exercise_id": 68, "Knee": "A little" },
            {
              "name": "Hyperextensions With No Hyperextension Bench",
              "exercise_id": 69,
              "Knee": "Yes"
            },
            { "name": "Inchworm", "exercise_id": 70, "Knee": "A little" },
            { "name": "Incline Push-Up", "exercise_id": 71, "Knee": "No" },
            { "name": "Incline Push-Up Close-Grip", "exercise_id": 72, "Knee": "Yes" },
            { "name": "Incline Push-Up Medium", "exercise_id": 73, "Knee": "A little" },
            {
              "name": "Incline Push-Up Reverse Grip",
              "exercise_id": 74,
              "Knee": "A little"
            },
            { "name": "Incline Push-Up Wide", "exercise_id": 75, "Knee": "No" },
            { "name": "Inverted Row", "exercise_id": 76, "Knee": "No" },
            { "name": "Iron Crosses (stretch)", "exercise_id": 77, "Knee": "No" },
            { "name": "Isometric Chest Squeezes", "exercise_id": 78, "Knee": "A little" },
            {
              "name": "Isometric Neck Exercise - Front And Back",
              "exercise_id": 79,
              "Knee": "No"
            },
            {
              "name": "Isometric Neck Exercise - Sides",
              "exercise_id": 80,
              "Knee": "No"
            },
            { "name": "Isometric Wipers", "exercise_id": 81, "Knee": "No" },
            { "name": "Jackknife Sit-Up", "exercise_id": 82, "Knee": "A little" },
            { "name": "Janda Sit-Up", "exercise_id": 83, "Knee": "No" },
            { "name": "Kneeling Arm Drill", "exercise_id": 84, "Knee": "Yes" },
            { "name": "Kneeling Forearm Stretch", "exercise_id": 85, "Knee": "No" },
            { "name": "Kneeling Hip Flexor", "exercise_id": 86, "Knee": "A little" },
            { "name": "Knee Across The Body", "exercise_id": 87, "Knee": "Yes" },
            { "name": "Knee Circles", "exercise_id": 88, "Knee": "A little" },
            { "name": "Knee Tuck Jump", "exercise_id": 89, "Knee": "No" },
            { "name": "Lateral Bound", "exercise_id": 90, "Knee": "No" },
            { "name": "Leg-Up Hamstring Stretch", "exercise_id": 91, "Knee": "No" },
            { "name": "Leg Lift", "exercise_id": 92, "Knee": "A little" },
            { "name": "Leg Pull-In", "exercise_id": 93, "Knee": "Yes" },
            {
              "name": "Linear 3-Part Start Technique",
              "exercise_id": 94,
              "Knee": "A little"
            },
            {
              "name": "Linear Acceleration Wall Drill",
              "exercise_id": 95,
              "Knee": "A little"
            },
            { "name": "Looking At Ceiling", "exercise_id": 96, "Knee": "No" },
            { "name": "Lower Back Curl", "exercise_id": 97, "Knee": "Yes" },
            { "name": "Lying Crossover", "exercise_id": 98, "Knee": "Yes" },
            { "name": "Lying Glute", "exercise_id": 99, "Knee": "A little" },
            { "name": "Lying Prone Quadriceps", "exercise_id": 100, "Knee": "Yes" },
            { "name": "Middle Back Stretch", "exercise_id": 101, "Knee": "A little" },
            { "name": "Mountain Climbers", "exercise_id": 102, "Knee": "No" },
            { "name": "Moving Claw Series", "exercise_id": 103, "Knee": "Yes" },
            { "name": "Natural Glute Ham Raise", "exercise_id": 104, "Knee": "Yes" },
            { "name": "Oblique Crunches", "exercise_id": 105, "Knee": "No" },
            {
              "name": "Oblique Crunches - On The Floor",
              "exercise_id": 106,
              "Knee": "A little"
            },
            { "name": "One Arm Against Wall", "exercise_id": 107, "Knee": "No" },
            { "name": "One Half Locust", "exercise_id": 108, "Knee": "A little" },
            { "name": "One Knee To Chest", "exercise_id": 109, "Knee": "Yes" },
            {
              "name": "On Your Side Quad Stretch",
              "exercise_id": 110,
              "Knee": "A little"
            },
            { "name": "Overhead Stretch", "exercise_id": 111, "Knee": "Yes" },
            { "name": "Overhead Triceps", "exercise_id": 112, "Knee": "No" },
            { "name": "Pelvic Tilt Into Bridge", "exercise_id": 113, "Knee": "No" },
            { "name": "Plank", "exercise_id": 114, "Knee": "A little" },
            { "name": "Plyo Push-up", "exercise_id": 115, "Knee": "No" },
            { "name": "Prone Manual Hamstring", "exercise_id": 116, "Knee": "A little" },
            { "name": "Pullups", "exercise_id": 117, "Knee": "Yes" },
            {
              "name": "Push-Ups - Close Triceps Position",
              "exercise_id": 118,
              "Knee": "Yes"
            },
            { "name": "Push-Ups With Feet Elevated", "exercise_id": 119, "Knee": "No" },
            { "name": "Push-Up Wide", "exercise_id": 120, "Knee": "No" },
            { "name": "Pushups", "exercise_id": 121, "Knee": "A little" },
            {
              "name": "Pushups (Close and Wide Hand Positions)",
              "exercise_id": 122,
              "Knee": "No"
            },
            { "name": "Push Up to Side Plank", "exercise_id": 123, "Knee": "No" },
            { "name": "Rear Leg Raises", "exercise_id": 124, "Knee": "No" },
            { "name": "Reverse Crunch", "exercise_id": 125, "Knee": "Yes" },
            { "name": "Rocket Jump", "exercise_id": 126, "Knee": "Yes" },
            { "name": "Runner\'s Stretch", "exercise_id": 127, "Knee": "Yes" },
            { "name": "Russian Twist", "exercise_id": 128, "Knee": "A little" },
            { "name": "Scapular Pull-Up", "exercise_id": 129, "Knee": "No" },
            { "name": "Scissors Jump", "exercise_id": 130, "Knee": "A little" },
            { "name": "Scissor Kick", "exercise_id": 131, "Knee": "A little" },
            { "name": "Seated Biceps", "exercise_id": 132, "Knee": "Yes" },
            { "name": "Seated Calf Stretch", "exercise_id": 133, "Knee": "A little" },
            { "name": "Seated Flat Bench Leg Pull-In", "exercise_id": 134, "Knee": "No" },
            {
              "name": "Seated Floor Hamstring Stretch",
              "exercise_id": 135,
              "Knee": "No"
            },
            { "name": "Seated Front Deltoid", "exercise_id": 136, "Knee": "A little" },
            { "name": "Seated Glute", "exercise_id": 137, "Knee": "No" },
            { "name": "Seated Hamstring", "exercise_id": 138, "Knee": "No" },
            { "name": "Seated Leg Tucks", "exercise_id": 139, "Knee": "Yes" },
            { "name": "Seated Overhead Stretch", "exercise_id": 140, "Knee": "No" },
            { "name": "Shoulder Circles", "exercise_id": 141, "Knee": "Yes" },
            { "name": "Shoulder Raise", "exercise_id": 142, "Knee": "A little" },
            { "name": "Shoulder Stretch", "exercise_id": 143, "Knee": "Yes" },
            {
              "name": "Side-Lying Floor Stretch",
              "exercise_id": 144,
              "Knee": "A little"
            },
            { "name": "Side Bridge", "exercise_id": 145, "Knee": "A little" },
            { "name": "Side Jackknife", "exercise_id": 146, "Knee": "Yes" },
            { "name": "Side Leg Raises", "exercise_id": 147, "Knee": "A little" },
            { "name": "Side Lying Groin Stretch", "exercise_id": 148, "Knee": "Yes" },
            { "name": "Side Neck Stretch", "exercise_id": 149, "Knee": "Yes" },
            { "name": "Side Standing Long Jump", "exercise_id": 150, "Knee": "A little" },
            { "name": "Side Wrist Pull", "exercise_id": 151, "Knee": "A little" },
            { "name": "Single-Arm Push-Up", "exercise_id": 152, "Knee": "A little" },
            { "name": "Single Leg Butt Kick", "exercise_id": 153, "Knee": "A little" },
            { "name": "Single Leg Glute Bridge", "exercise_id": 154, "Knee": "A little" },
            { "name": "Sit-Up", "exercise_id": 155, "Knee": "A little" },
            { "name": "Sit Squats", "exercise_id": 156, "Knee": "Yes" },
            { "name": "Spider Crawl", "exercise_id": 157, "Knee": "No" },
            { "name": "Spinal Stretch", "exercise_id": 158, "Knee": "A little" },
            { "name": "Split Jump", "exercise_id": 159, "Knee": "Yes" },
            { "name": "Split Squats", "exercise_id": 160, "Knee": "No" },
            {
              "name": "Standing Gastrocnemius Calf Stretch",
              "exercise_id": 161,
              "Knee": "No"
            },
            { "name": "Standing Hip Circles", "exercise_id": 162, "Knee": "Yes" },
            { "name": "Standing Hip Flexors", "exercise_id": 163, "Knee": "A little" },
            {
              "name": "Standing Lateral Stretch",
              "exercise_id": 164,
              "Knee": "A little"
            },
            { "name": "Standing Long Jump", "exercise_id": 165, "Knee": "A little" },
            { "name": "Standing Pelvic Tilt", "exercise_id": 166, "Knee": "No" },
            {
              "name": "Standing Soleus And Achilles Stretch",
              "exercise_id": 167,
              "Knee": "A little"
            },
            { "name": "Standing Toe Touches", "exercise_id": 168, "Knee": "Yes" },
            {
              "name": "Standing Towel Triceps Extension",
              "exercise_id": 169,
              "Knee": "No"
            },
            { "name": "Star Jump", "exercise_id": 170, "Knee": "Yes" },
            { "name": "Step-up with Knee Raise", "exercise_id": 171, "Knee": "No" },
            { "name": "Stomach Vacuum", "exercise_id": 172, "Knee": "No" },
            { "name": "Superman", "exercise_id": 173, "Knee": "No" },
            { "name": "The Straddle", "exercise_id": 174, "Knee": "A little" },
            { "name": "Toe Touchers", "exercise_id": 175, "Knee": "Yes" },
            { "name": "Trail Running/Walking", "exercise_id": 176, "Knee": "No" },
            { "name": "Triceps Stretch", "exercise_id": 177, "Knee": "Yes" },
            { "name": "Tricep Side Stretch", "exercise_id": 178, "Knee": "Yes" },
            { "name": "Tuck Crunch", "exercise_id": 179, "Knee": "A little" },
            { "name": "Upper Back-Leg Grab", "exercise_id": 180, "Knee": "Yes" },
            { "name": "Upper Back Stretch", "exercise_id": 181, "Knee": "No" },
            { "name": "Upward Stretch", "exercise_id": 182, "Knee": "A little" },
            { "name": "V-Bar Pullup", "exercise_id": 183, "Knee": "Yes" },
            { "name": "Wide-Grip Rear Pull-Up", "exercise_id": 184, "Knee": "No" },
            { "name": "Windmills", "exercise_id": 185, "Knee": "Yes" },
            { "name": "Wind Sprints", "exercise_id": 186, "Knee": "A little" },
            { "name": "World\'s Greatest Stretch", "exercise_id": 187, "Knee": "No" },
            { "name": "Wrist Circles", "exercise_id": 188, "Knee": "Yes" }
          ]';
        $data = json_decode($exercise_list,true);
        foreach($data as $exercise){
            exercise::factory()->create(['ex_id'=>$exercise['exercise_id'],'name'=>$exercise['name'],'knee'=>$exercise['Knee']]);
        }


    }

}
